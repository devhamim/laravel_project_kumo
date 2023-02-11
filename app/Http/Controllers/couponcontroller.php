<?php

namespace App\Http\Controllers;

use App\Models\coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class couponcontroller extends Controller
{

    // user login block
    public function __construct()
    {
        $this->middleware('auth');
    }


    // coupon page view
    function coupon(){
        $coupons = coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }

    // coupon store
    function coupon_store(Request $request){
        coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'discount'=>$request->discount,
            'expired'=>$request->expired,
            'type'=>$request->type,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Coupon Add Successfully');
    }

    // coupon delete
    function coupon_delete($coupon_id){
        coupon::find($coupon_id)->delete();
        return back()->with('coupon_delete', 'Coupon Delete Successfully');
    }

}
