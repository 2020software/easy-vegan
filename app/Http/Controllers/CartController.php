<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function AddCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->discount_price == NULL) {
            Cart::add([
                'id' => '$id',
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'weight' => 1,
                'image' => $product->thambnail
            ]);

            return response()->json(['success' => 'カートに追加できました']);
        } else {
            Cart::add([
                'id' => '$id',
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => 1,
                'image' => $product->thambnail
            ]);
            return response()->json(['success' => '割引価格で追加できました']);
        }
    }


    // カートページ表示
    public function MyCart()
    {
        return view('my_cart');
    }

    public function GetCartProduct()
    {
        $carts = Cart::content();
        $cartQuantity = Cart::count();  // カートにあるアイテムの数を知りたい場合
        $cartTotal = Cart::total(); // 価格と数量を指定して、カート内のすべてのアイテムの計算された合計を取得できます。

        return response()->json(array(
            'carts' => $carts,
            'cartQuantity' => $cartQuantity,
            'cartTotal' => $cartTotal
        ));
    }

    public function RemoveCartProduct($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'できました']);
    }

    public function Checkout()
    {
        if (Auth::check()) {
                    
        }
    }
    }
}
