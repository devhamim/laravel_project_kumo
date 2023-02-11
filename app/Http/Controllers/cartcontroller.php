<?php

namespace App\Http\Controllers;

use App\Models\card;
use App\Models\inventory;
use App\Models\prodact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class cartcontroller extends Controller
{
    // prodact card add
    function add_cart(Request $request){
        if(Auth::guard('customerlogin')->id()){
            $request->validate([
                'color_id'=>'required',
                'size_id'=>'required',
                'quantity'=>'required',

            ]);

            $quantity = inventory::where('prodact_id' , $request->prodact_id)->where('color_id' , $request->color_id)->where('size_id' , $request->size_id)->first()->quantity;

            if($quantity >= $request->quantity){
                if(card::where('prodact_id', $request->prodact_id)->where('customer_id', Auth::guard('customerlogin')->id())->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
                    card::where('prodact_id', $request->prodact_id)->where('customer_id', Auth::guard('customerlogin')->id())->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);

                    return back()->with('success', 'Product Update Successfully');
                }
                else{
                    card::insert([
                        'customer_id'=>Auth::guard('customerlogin')->id(),
                        'prodact_id'=>$request->prodact_id,
                        'color_id'=>$request->color_id,
                        'size_id'=>$request->size_id,
                        'quantity'=>$request->quantity,
                        'created_at'=> Carbon::now(),

                    ]);
                }
                return back()->with('success', 'Product Add Successfully');
            }
            else{
                return back()->with('stock', 'Out Of Stock Total Product: '.$quantity);
            }

        }
        else{
            return redirect()->route('customer.reglogin')->with('login', 'Please Login');
        }
    }

    // cart remove
    function cart_remove($cart_id){
        card::find($cart_id)->delete();
        return back();
    }


    // cart update
    function cart_update(Request $request){
        $carts = $request->all();
        foreach($carts['quantity'] as $cart_id=>$quantity){
            card::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);

        }
        return back()->with('update', 'Cart Update Successfully');
    }
}
