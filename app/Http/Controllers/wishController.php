<?php

namespace App\Http\Controllers;

use App\Models\wish;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class wishController extends Controller
{
    //wish view
    function wish(){
        return view('frontend.wish');
    }

    // add wish
    function add_wish(Request $request){
        if(Auth::guard('customerlogin')->id()){
            wish::insert([
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'prodact_id'=>$request->prodact_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'Your wish add successfully');
        }
        else{
            return redirect()->route('customer.reglogin')->with('wish_login', 'Please Login');
        }

    }

    // wish delete
    function wish_delete($wish_id){
        wish::find($wish_id)->delete();
        return back();
    }
}
