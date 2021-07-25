<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{
    public function AddCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 定価商品
        if ($product->discount_price == NULL) {
            Cart::add([
                'id' => '$id',
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->selling_price,
                'email' => $product->product_code,
                'weight' => 1,
                'image' => $product->thambnail
            ]);

            return response()->json(['success' => 'カートに追加できました']);
        // 割引商品
        } else {
            Cart::add([
                'id' => '$id',
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'email' => $product->product_code,
                'weight' => 1,
                'image' => $product->thambnail
            ]);
            return response()->json(['success' => 'カートに追加できました']);

        }
    }


    // カートページ表示
    public function MyCart()
    {
        return view('products.my_cart');
    }

    public function GetCartProduct()
    {
        $carts = Cart::content();   // カートのコンテンツも取得
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
        return response()->json(['success' => '削除できました']);
    }
    public function Accounting()
    {
        if (Auth::check()) {
            if (Cart::total() > 0) {
                $carts = Cart::content();   // カートのコンテンツも取得
                $cartQuantity = Cart::count();  // カートにあるアイテムの数を知りたい場合
                $cartTotal = Cart::total(); // 価格と数量を指定して、カート内のすべてのアイテムの計算された合計を取得できます。

                return view('products.checkout', compact('carts', 'cartQuantity', 'cartTotal'));  // foreach で使う
            } else {
                $notification = array(
                    'message' => '少なくとも一つはカートに追加する必要があります',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }
        }
    }
    
    
}
