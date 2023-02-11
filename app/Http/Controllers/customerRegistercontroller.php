<?php

namespace App\Http\Controllers;

use App\Models\customer_email_verify;
use App\Models\customerLogin;
use App\Notifications\customeremailverifynotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class customerRegistercontroller extends Controller
{
    function customer_store(Request $request){
        customerLogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt( $request->password),
            'created_at'=>Carbon::now(),
        ]);

        // customer email verify
        $customer = customerLogin::where('email', $request->email)->firstOrFail();
        $customer_info = customer_email_verify::create([
            'customer_id'=>$customer->id,
            'token' =>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new customeremailverifynotification($customer_info));

        return back()->withEmailverify('We have sent you a verification mail, please verify your mail');
    }
    // customer email verify
    function customer_email_verify($token){
        $customer = customer_email_verify::where('token', $token)->firstOrFail();
        customerLogin::find($customer->customer_id)->update([
            'email_verify_at'=>Carbon::now()->format('Y-m-d'),
        ]);
        return back()->with('verify_mail', 'Email verify successfully');
    }

}
