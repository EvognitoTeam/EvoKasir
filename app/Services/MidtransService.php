<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;

class MidtransService
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction =  env('MIDTRANS_IS_PRODUCTION'); // true jika sudah go live
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($orderId, $grossAmount, $customer, $itemDetails, $mitra)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'EvoKasir-' . $mitra . '-' . $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customer,
            'item_details' => $itemDetails,
            'payment_type' => 'qris',
            'qris' => [
                'acquirer' => 'gopay',
            ],
        ];

        return CoreApi::charge($params); // <- KUNCI UTAMA
    }
}
