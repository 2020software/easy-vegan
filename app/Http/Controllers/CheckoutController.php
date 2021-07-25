<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;


class CheckoutController extends Controller
{
    public function Checkout(Request $request)
    {
        // dd($request->all());    postを確認する = dd()

        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;

        $cartTotal = Cart::total();  // カートにあるアイテムの数を知りたい場合

        return view('products.verification', compact('data', 'cartTotal'));
    }
}
