<?php

namespace App\Http\Controllers;

use App\Models\billingdetailss;
use App\Models\customerLogin;
use App\Models\order;
use App\Models\orderproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use PDF;

class customerProfilecontroller extends Controller
{
    // customer profile view
    function customer_profile(){
        return view('frontend.customer_profile');
    }

    // customer profile update
    function customer_profile_store(Request $request){
        if($request->password == ''){
            if($request->photo == ''){
                customerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                ]);
                return back()->with('success', 'Profile Update Successfully');
            }
            else{
                $customer_photo = $request->photo;
                $extention = $customer_photo->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id(). '.' .$extention;
                Image::make($customer_photo)->resize(450, 450)->save(public_path('uplodes/customerprofile/'.$file_name));

                customerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back()->with('success', 'Profile Update Successfully');
            }
        }
        else{
            $request->validate([
                'old_password'=>'required',
                'password'=>'required',
            ]);

            if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                customerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'password'=>bcrypt($request->password),
                ]);
            }
            else{
                return back()->with('password_Wrong', 'Old Password Wrong');
            }
            if($request->photo == ''){
                customerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                ]);
                return back()->with('success', 'Profile Update Successfully');
            }
            else{
                $customer_photo = $request->photo;
                $extention = $customer_photo->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id() . '.' .$extention;
                Image::make($customer_photo)->resize(450, 450)->save(public_path('uplodes/customerprofile/'.$file_name));

                customerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back()->with('success', 'Profile Update Successfully');
            }
        }
    }

    // customer order
    function customer_order(){
        $order_product = order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer_order', [
            'order_product'=>$order_product,
        ]);
    }

    // invoice download
    function invoice_download($order_id){
        $order_info = order::find($order_id);
        $billingdetails = billingdetailss::where('order_id', $order_info->order_id)->get();
        $order_product = orderproduct::where('order_id', $order_info->order_id)->get();
        $invoice = PDF::loadView('invoice.invoice_download', [
            'order_info'=> $order_info,
            'billingdetails'=> $billingdetails,
            'order_product'=> $order_product,
        ]);
        return $invoice->download('invoice.pdf');
    }

}
