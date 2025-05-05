<?php

namespace App\Http\Controllers\Customers;

use App\Models\Package;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart');

        $totalQty = array_sum(array_column($cart, 'qty'));

        $totalPrice = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['qty'] * $item['price']);
        }, 0);

        $transactionDate = collect($cart)->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d'); // Ubah ke format MySQL
        })->min(); 

        $transaction = new Transaction();
        $transaction->date = $transactionDate;
        $transaction->users_id = $user->id;
        $transaction->total = $totalPrice;
        $transaction->qty = $totalQty;
        $transaction->status = 'Unpaid';
        $saved = $transaction->save();

        foreach ($cart as $item) {
            // dd($cart);
            $details = new TransactionDetail();
            $details->package_id = $item['id'];
            $details->price = $item['price'];
            $details->transactions_id = $transaction->id;
            $details->name = $user->name;
            $details->phone = $user->phone;
            $details->save();
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->total,
            ),
            'customer_details' => array(
                'name' => $details->name,
                'phone' => $details->phone,
            ),
        );
        // dd($params);
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // session()->forget('cart');
        // dd($snapToken);
        return view('customer.checkout',  compact('snapToken', 'transaction', 'cart'));
    }

    public function invoice($id)
    {
        $transaction = Transaction::with(['user', 'transactionDetails.package'])->findOrFail($id);
        return view('customer.invoice',  compact('transaction'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            $transaction = Transaction::find($request->order_id);
            $transaction->update(['status' => 'Paid']);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // Misalnya, ambil transaksi terbaru yang baru saja dibuat
        $transaction = Transaction::latest()->first();

        // Pastikan untuk mengirimkan data transaksi ke view
        return view('checkout', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
