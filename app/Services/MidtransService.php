<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Reservation;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Reservation $reservation)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'RESV-' . $reservation->id,
                'gross_amount' => $reservation->total_price,
            ],
            'customer_details' => [
                'first_name' => $reservation->customer_name,
                'email' => $reservation->email,
                'phone' => $reservation->phone,
            ],
        ];
    
        $transaction = Snap::createTransaction($params);
    
        return $transaction->token;
    }    
}
