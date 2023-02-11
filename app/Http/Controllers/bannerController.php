<?php

namespace App\Http\Controllers;

use App\Models\banner_img;
use App\Models\shopbanner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class bannerController extends Controller
{
    //admin add banner view
    function add_banner(){
        $banner_img =  banner_img::all();
        return view('admin.all_banner_image.add_banner', [
            'banner_img'=>$banner_img,
        ]);
    }

    // banner store
    function banner_store(Request $request){
        $banner_id = banner_img::insertGetId([
            'banner_type'=>$request->banner_type,
            'banner_title'=>$request->banner_title,
            'banner_desp'=>$request->banner_desp,
            'created_at'=>Carbon::now(),
        ]);

        $banner_img = $request->banner_img;
        $extention = $banner_img->getClientOriginalExtension();
        $file_name = Str::random(5). rand(1000,9999).'.'.$extention;
        Image::make($banner_img)->save(public_path('uplodes/banner/'.$file_name));

        banner_img::find($banner_id)->update([
            'banner_img'=>$file_name,
        ]);

        return back()->with('success', 'Banner Image Add Successfully');
    }

    // banner delete
    function banner_delete($banner_id){
        $bann_img = banner_img::where('id', $banner_id)->first()->banner_img;
        $bann_del = public_path('uplodes/banner/'. $bann_img);
        unlink($bann_del);

        banner_img::find($banner_id)->delete();
        return back()->with('ban_delete', 'Banner delete successfully');
    }

    // shop banner view
    function shop_banner(){
        $shop_banner = shopbanner::all();
        return view('admin.all_banner_image.shop_banner', [
            'shop_banner'=>$shop_banner,
        ]);
    }
    //shop banner store
    function shop_banner_store(Request $request){
        $shop_banner = $request->shop_banner;
        $shop_extention = $shop_banner->getClientOriginalExtension();
        $file_name = Str::random(5). rand(1000, 99999).'.'.$shop_extention;
        Image::make($shop_banner)->save(public_path('uplodes/shop_banner/'.$file_name));

        shopbanner::insert([
            'banner_img'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Shop banner add successfully');
    }
    // shop banner delete
    function shop_banner_delete($shop_id){
        $shop_img_del = shopbanner::where('id', $shop_id)->first()->banner_img;
        $shop_del = public_path('uplodes/shop_banner/'. $shop_img_del);
        unlink($shop_del);

        shopbanner::find($shop_id)->delete();
        return back()->with('shop_delete', 'Shop banner delete successfully');
    }
}
