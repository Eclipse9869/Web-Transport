<?php

namespace App\Http\Controllers\Customers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $cart = session()->get('cart');
        // dd($cart);
        return view('customer.cart', compact('cart'));
    }
    public function addCart(Request $request, $id)
    {
        $user = Auth::user()->id;
        $package = Package::find($id);
        $cart = session()->get('cart');
        // dd($cart);
        if (!isset($cart[$id])) {
            // Cart ada isi nya
            $cart[$id] = [
                "user_id" => $user,
                "id" => $package->id,
                "name" => $package->name,
                "price" => $package->price,
                "qty" => 1,
                "date" => now()->format('d F Y'),
                "type" => $package->type->name,
            ];
            session()->put('cart', $cart);
        }
        return redirect('/cart')->with('success', 'Produk berhasil ditambahkan kedalam keranjang');
    }

    // public function updateCart(Request $request)
    // {
    //     $cart = session()->get('cart');
    //     $id = $request->input('id');
    //     $quantity = $request->input('quantity');

    //     if (isset($cart[$id])) {
    //         if ($quantity > 0) {
    //             $cart[$id]['qty'] = $quantity;
    //         } else {
    //             unset($cart[$id]);
    //         }
    //         session()->put('cart', $cart);
    //     }

    //     return response()->json(['success' => true]);
    // }

    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan dalam keranjang.']);
        }

        if ($quantity > 0) {
            $cart[$id]['qty'] = $quantity;
        } else {
            unset($cart[$id]); // Hapus produk jika qty <= 0
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function updateDate(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $date = $request->input('date');

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan dalam keranjang.']);
        }

        $cart[$id]['date'] = $date;
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $date = $request->input('date');

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan dalam keranjang.']);
        }

        if ($quantity) {
            $cart[$id]['qty'] = $quantity;
        }
        
        if ($date) {
            $cart[$id]['date'] = $date;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        return redirect('/cart')->with('info', 'Produk berhasil dihapus');
    }
}
