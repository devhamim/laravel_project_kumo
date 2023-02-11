<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class ordercontroller extends Controller
{
    //order view
      function order(){
        $customer_order = order::all();
        return view('admin.order.order', [
            'customer_order'=>$customer_order,
        ]);
      }

    // status change
    function order_status(Request $request){
        $after_explode = explode(',', $request->status);
        order::where('order_id', $after_explode[0])->update([
            'status'=>$after_explode[1],
        ]);
        return back();
    }

}
