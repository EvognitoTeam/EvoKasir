<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class ApiOrderController extends Controller
{
    public function updateOrderStatus(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $issuer = $request->input('issuer');
        $status = $request->input('status');

        // Temukan order berdasarkan transaction_id dan update statusnya
        $order = Order::where('transaction_id', $transactionId)->first();

        if ($order) {
            $order->payment_status = '2'; // Atur status sesuai kebutuhan
            $order->issuer = $issuer; // Atur status sesuai kebutuhan
            $order->save();

            return response()->json(['message' => 'Order status updated successfully.']);
        }

        return response()->json(['message' => 'Order not found.'], 404);
    }

    public function updatePaymentStatus($order_code)
    {
        $transaction = Order::where('order_code', $order_code)->first();

        if (!$transaction) {
            return response()->json(['payment_status' => 'not_found'], 404);
        }

        return response()->json(['payment_status' => $transaction->payment_status]);
    }

    public function sendOrder(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'mitra_id' => 'required|integer|exists:mitra,id',
            'name' => 'nullable|string|max:255',
            'table_number' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'orders' => 'required|array|min:1',
            'orders.*.product_id' => 'required|integer|exists:products,id',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.price' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $orderCode = '';
            for ($i = 0; $i < 6; $i++) {
                $orderCode .= $characters[rand(0, strlen($characters) - 1)];
            }
            $totalPrice = collect($validated['orders'])->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
            $totalAfterDiscount = $totalPrice - ($validated['discount'] ?? 0);
            if ($totalAfterDiscount <= 0) {
                $totalAfterDiscount = 0;
            }

            $order = Order::create([
                'mitra_id' => $validated['mitra_id'],
                'user_id' => $validated['user_id'],
                'order_code' => $orderCode,
                'name' => $validated['name'],
                'table_number' => $validated['table_number'],
                'total_price' => $totalPrice,
                'totalAfterDiscount' => $totalAfterDiscount,
                'discount' => $validated['discount'],
                'status' => 'pending',
                'payment_status' => 2,
            ]);

            foreach ($validated['orders'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                // Kurangi stok produk
                $product = Menu::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            Log::info("Berhasil!!");
            Log::info($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil disimpan.',
                'order_id' => $orderCode
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error("Error : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
