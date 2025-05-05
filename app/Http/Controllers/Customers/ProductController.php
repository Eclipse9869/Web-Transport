<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Package;

class ProductController extends Controller
{
    public function index()
    {
        $package = Package::with('packageImages')->where('status', 'available')->get();
        return view('customer.shop', compact('package'));
    }
    public function detail($id)
    {
        $package = Package::with('packageImages')->findOrFail($id);
        return view('customer.detail-product', compact('package'));
    }
}
