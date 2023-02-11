<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\billingdetailss;
use App\Models\card;
use App\Models\city;
use App\Models\country;
use App\Models\inventory;
use App\Models\order;
use App\Models\orderproduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Str;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)  
    {
        $data = session('data');

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => 100 * $data['sub_total']+ $data['charge'],
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

         // order
         $order_id = '#'.Str::random(3).'-'.rand(10000000,999999999);
         order::insert([
             'order_id'=>$order_id,
             'customer_id'=>Auth::guard('customerlogin')->id(),
             'sub_total'=>$data['sub_total'],
             'total'=>$data['sub_total'] + $data['charge'],
             'discount'=>$data['discount'],
             'charge'=>$data['charge'],
             'payment_method'=>$data['payment_method'],
             'created_at'=>Carbon::now(),
         ]);

         // billing details
         billingdetailss::insert([
             'order_id'=>$order_id,
             'customer_id'=>Auth::guard('customerlogin')->id(),
             'name'=>$data['name'],
             'email'=>$data['email'],
             'company'=>$data['company'],
             'mobile'=>$data['mobile'],
             'address'=>$data['address'],
             'country_id'=>$data['country_id'],
             'city_id'=>$data['city_id'],
             'zip'=>$data['zip'],
             'notes'=>$data['notes'],
             'created_at'=>Carbon::now(),
         ]);


         // oder product

         $carts = card::where('customer_id', Auth::guard('customerlogin')->id())->get();

         foreach($carts as $cart){
             orderproduct::insert([
                 'order_id'=>$order_id,
                 'customer_id'=>Auth::guard('customerlogin')->id(),
                 'prodact_id'=>$cart->prodact_id,
                 'price'=>$cart->rel_to_prodact->price,
                 'color_id'=>$cart->color_id,
                 'size_id'=>$cart->size_id,
                 'quantity'=>$cart->quantity,
                 'created_at'=>Carbon::now(),
             ]);


             inventory::where('prodact_id', $cart->prodact_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

             //card delete after order

             card::where('customer_id', Auth::guard('customerlogin')->id())->delete();
         }

         // ditect route na baniya o pathano jai vareabol akara
         // return view('frontend.order_success', [
         //     'order_id'=>$order_id,
         // ]);

         return redirect()->route('order.success')->with([
             'order_id'=>$order_id,
         ]);
    }
}
