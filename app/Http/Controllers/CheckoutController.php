<?php

namespace App\Http\Controllers;

use App\Cart;
use Exception;
use Midtrans\Snap;
use App\Transaction;
use Midtrans\Config;
use App\TransactionDetail;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $user = Auth::user();
        $user->update($request->except('total_harga'));

        // Proses checkout
        $code = 'SEMINKUY-' . mt_rand(0000,9999);
        $carts = Cart::with(['event','user'])
                    ->where('users_id', Auth::user()->id)
                    ->get(); 

        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'total_harga' => $request->total_harga,
            'status' => 'PENDING',
            'kode' => $code
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(0000,9999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'events_id' => $cart->event->id,
                'harga' => $cart->event->harga,
                'resi' => '',
                'kode' => $trx
            ]);
        }
            // Delete cart data
            Cart::with(['event','user'])
            ->where('users_id', Auth::user()->id)
            ->delete();

            // Konfigurasi midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            // Buat array untuk dikirim ke midtrans
            $midtrans = [
                'transaction_details' => [
                    'order_id' =>  $code,
                    'gross_amount' => (int) $request->total_harga,
                ],
                'customer_details' => [
                    'first_name'    => Auth::user()->name,
                    'email'         => Auth::user()->email,
                ],
                'enabled_payments' => ['bank_transfer','gopay'],
                'vtweb' => []
            ];

            try {
                // Ambil halaman payment midtrans
                $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
    
                // Redirect ke halaman midtrans
                return redirect($paymentUrl);
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

    }

    public function callback(Request $request)
    {
         // Set konfigurasi midtrans
         Config::$serverKey = config('services.midtrans.serverKey');
         Config::$isProduction = config('services.midtrans.isProduction');
         Config::$isSanitized = config('services.midtrans.isSanitized');
         Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();

     
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

       
        $transaction = Transaction::findOrFail($order_id);

         if ($status == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->status = 'PENDING';
                }
                else {
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if ($status == 'SETTLEMENT'){
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'PENDING'){
            $transaction->status = 'PENDING';
        }
        else if ($status == 'FAILURE') {
            $transaction->status = 'CANCELLED';
        }
        else if ($status == 'EXPIRE') {
            $transaction->status = 'CANCELLED';
        }
        else if ($status == 'CANCEL') {
            $transaction->status = 'CANCELLED';
        }

         // Simpan transaksi
         $transaction->save();

         // Kirimkan email
         if ($transaction)
         {
             if($status == 'capture' && $fraud == 'accept' )
             {
                 //
             }
             else if ($status == 'SETTLEMENT')
             {
                 //
             }
             else if ($status == 'SUCCESS')
             {
                 //
             }
             else if($status == 'capture' && $fraud == 'challenge' )
             {
                 return response()->json([
                     'meta' => [
                         'code' => 200,
                         'message' => 'Midtrans Payment Challenge'
                     ]
                 ]);
             }
             else
             {
                 return response()->json([
                     'meta' => [
                         'code' => 200,
                         'message' => 'Midtrans Payment not Settlement'
                     ]
                 ]);
             }
 
             return response()->json([
                 'meta' => [
                     'code' => 200,
                     'message' => 'Midtrans Notification Success'
                 ]
             ]);
         }

    }
}
