<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

class VerificationController extends Controller
{
    public function verificationOrder(Request $request)
    {       
        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'address_id' => $request->shipping_address,
            'name' => $request->name,
            'email' => $request->email,
            'order_year' => Carbon::now()->format('Y'),
            'order_month' => Carbon::now()->format('m'),
            'order_date' => Carbon::now()->format('d')
        ]);

        $invoice = Order::findOrFail($order_id);
        $data = [
            'name' => $invoice->name,
            'email' => $invoice->email
        ];

        Mail::to($request->email)->send(new OrderMail($data));  // Mail/OrderMail.php

        Cart::destroy();

        $notification = array(
            'message' => '注文ができました',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }
}
