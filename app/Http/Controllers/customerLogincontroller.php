<?php

namespace App\Http\Controllers;

use App\Models\customerLogin;
use App\Models\customerpassreset;
use App\Notifications\customerpassresetnotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class customerLogincontroller extends Controller
{

    // customer login
    function customer_login(Request $request){
        $request->validate([
            '*'=>'required',
        ],[
            'g-recaptcha-response.required'=>'captcha field is required.'
        ]);
        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            if(Auth::guard('customerlogin')->user()->email_verify_at == null){
                return back()->with('verify_login', 'Plese verify your email');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect()->route('customer.reglogin');
        }
    }

    // customer logout
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }

    // customer forget password reset
    function customer_pass_reset(){
        return view('frontend.password_reset');
    }
    // customer forget password reset mail send
    function customer_pass_reset_send(Request $request){
        $customer = customerLogin::where('email', $request->email)->firstOrFail();
        customerpassreset::where('customer_id', $customer->id)->delete();

        $customer_info = customerpassreset::create([
            'customer_id'=> $customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);
        Notification::send($customer, new customerpassresetnotification($customer_info));
        return back()->with('pass_reset', 'We are send you a mail, Please chack your mail inbox');
    }
    // customer password reset mail
    function customer_pass_mail_reset($token){
        return view('frontend.customer_pass_mail_reset', [
            'token'=>$token,
        ]);
    }

    // customer passeord reset confarm
    function customer_pass_reset_confirm(Request $request){
        $customer = customerpassreset::where('token', $request->token)->firstOrFail();
        customerLogin::find($customer->customer_id)->update([
            'password'=>bcrypt($request->password),
        ]);
        $customer->delete();
        return redirect()->route('customer.reglogin')->with('success', 'Password Reset Successfully');
    }
}
