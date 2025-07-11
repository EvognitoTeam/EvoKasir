<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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

            $this->sendNotification($order);

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
            'cashier_id' => 'required|integer|exists:users,id',
            'mitra_id' => 'required|integer|exists:mitra,id',
            'name' => 'nullable|string|max:255',
            'table_number' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'discount_id' => 'nullable|integer',
            'getPayment' => 'required|integer',
            'cashChange' => 'required|integer',
            'orders' => 'required|array|min:1',
            'orders.*.product_id' => 'required|integer|exists:products,id',
            'orders.*.note' => 'nullable|string|max:500', // Catatan bisa kosong, tipe string, max 500 karakter
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
                'cashier_id' => $validated['cashier_id'],
                'order_code' => $orderCode,
                'name' => $validated['name'],
                'table_number' => $validated['table_number'],
                'total_price' => $totalPrice,
                'totalAfterDiscount' => $totalAfterDiscount,
                'discount' => $validated['discount'],
                'discountId' => $validated['discount_id'],
                'getPayment' => $validated['getPayment'],
                'cashChange' => $validated['cashChange'],
                'status' => 'pending',
                'payment_status' => 2,
            ]);

            foreach ($validated['orders'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'notes' => $item['note'],
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

    public function getDiscount(Request $request)
    {
        $mitra = Mitra::findOrFail($request->mitra_id);

        if (empty($mitra)) {
            return response()->json(['response_code' => '403', 'message' => 'Mitra not found']);
        }

        $discounts = Coupon::where('mitra_id', $mitra->id)
            ->where('is_member_only', 0)
            ->where('expired_date', '>=', now())
            ->get();

        if (empty($discounts)) {
            return response()->json(['response_code' => '403', 'message' => 'Discount not found']);
        }

        return response()->json(['response_code' => 200, 'message' => 'Discount retrieved successfully', 'data' => $discounts]);
    }

    public function getOrders(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required|integer|exists:mitra,id',
            'cashier_id' => 'nullable|integer|exists:users,id',
        ]);

        $mitra = Mitra::find($request->mitra_id);

        $query = Order::with(['items.product', 'table', 'user'])
            ->orderBy('created_at', 'desc')
            ->where('mitra_id', $mitra->id);

        if ($request->filled('cashier_id')) {
            $query->where('cashier_id', $request->cashier_id);
        }

        $orders = $query->get();

        return response()->json([
            'response_code' => '200',
            'message' => 'Orders data successfully retrieved',
            'orders' => $orders,
        ]);
    }

    private function sendNotification(Order $order)
    {
        try {
            $order->loadMissing(['table', 'mitra']);

            $playerIds = User::where('mitra_id', $order->mitra_id)
                ->where('is_login', 1)
                ->whereNotNull('onesignalid')
                ->pluck('onesignalid')
                ->toArray();

            if (empty($playerIds)) {
                return;
            }

            $appId = config('services.onesignal.app_id');
            $apiKey = config('services.onesignal.api_key');

            $fields = [
                'app_id' => $appId,
                'include_player_ids' => $playerIds, // <-- Sesuai dokumentasi OneSignal
                'headings' => ['en' => "Pesanan Baru #{$order->order_code}"],
                'contents' => ['en' => "Meja {$order->table->name} memesan, total Rp " . number_format($order->total_price, 0, ',', '.')],
                'url' => route('admin.orders.detail', [
                    'slug' => $order->mitra->mitra_slug,
                    'order_code' => $order->order_code
                ]),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $apiKey,
                'Content-Type' => 'application/json'
            ])->post('https://onesignal.com/api/v1/notifications', $fields);

            if (!$response->successful()) {
                Log::error('OneSignal Failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('OneSignal Exception: ' . $e->getMessage());
        }
    }
}
