<?php

namespace App\Http\Controllers;

use App\Models\billingdetailss;
use App\Models\card;
use App\Models\city;
use App\Models\country;
use App\Models\inventory;
use App\Models\order;
use App\Models\orderproduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class checkoutcontroller extends Controller
{
    function checkout(){
        $count = card::where('customer_id', Auth::guard('customerlogin')->id())->count();
        $carts = card::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $countrys = country::all();
        return view('frontend.checkout', [
            'count'=>$count,
            'carts'=>$carts,
            'countrys'=>$countrys,
        ]);
    }


    // ajax url county id
    function getcity(Request $request){
        $citys = city::where('country_id', $request->country_id)->get();

        $str = '<option value="">-- Select City --</option>';

        foreach($citys as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }

        echo $str;
    }


    // order store
    function order_store(Request $request){
        // cash on delivery
        if($request->payment_method == 1) {
        // order
        $order_id = '#'.Str::random(3).'-'.rand(10000000,999999999);
        order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'sub_total'=>$request->sub_total,
            'total'=>$request->sub_total + $request->charge,
            'discount'=>$request->discount,
            'charge'=>$request->charge,
            'payment_method'=>$request->payment_method,
            'created_at'=>Carbon::now(),
        ]);

        // billing details
        billingdetailss::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'name'=>$request->name,
            'email'=>$request->email,
            'company'=>$request->company,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zip'=>$request->zip,
            'notes'=>$request->notes,
            'created_at'=>Carbon::now(),
        ]);


        // oder product

        $carts = card::where('customer_id', Auth::guard('customerlogin')->id())->get();

        foreach($carts as $cart){
            orderproduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'prodact_id'=>$cart->prodact_id,
                'price'=>$cart->rel_to_prodact->after_discount,
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
         // cash on delivery end

        // ssl commers payment method
        elseif($request->payment_method == 2){
            $data = $request->all();
            return redirect()->route('pay')->with('data', $data);
        }
        // steipe payment methoed
        else{
            $data = $request->all();
            return view('frontend.stripe', [
                'data'=>$data,
            ]);
        }
    }

    // order success
    function order_success(){
        if(session('order_id')){
            return view('frontend.order_success');
        }
        else{
            abort(404);
        }
    }
}
