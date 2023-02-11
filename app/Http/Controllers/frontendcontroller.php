<?php

namespace App\Http\Controllers;

use App\Models\banner_img;
use App\Models\card;
use App\Models\catagory;
use App\Models\color;
use App\Models\coupon;
use App\Models\inventory;
use App\Models\orderproduct;
use App\Models\prodact;
use App\Models\size;
use App\Models\thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Product;
use Cookie;
use Illuminate\Support\Arr;

class frontendcontroller extends Controller
{
    function index(){

        // cookies
        $recent_view_product = json_decode(cookie::get('recent_view'), true);

        if ($recent_view_product == null){
            $recent_view_product = [];
            $after_unique = array_unique($recent_view_product);
        }
        else{
            $after_unique = array_unique($recent_view_product);
        }
        $recent_view_product = prodact::find($after_unique);

        $catagories = catagory::all();
        $products = prodact::all();
        $banner_img = banner_img::all();
        $best_selling = orderproduct::groupBy('prodact_id')
        ->selectRaw('sum(quantity) as sum, prodact_id')
        ->orderBy('quantity', 'DESC')
        ->havingRaw('sum >= 2')
        ->get();
        return view('frontend.index', [
            'catagories'=> $catagories,
            'products'=> $products,
            'banner_img'=> $banner_img,
            'best_selling'=> $best_selling,
            'recent_view_product'=> $recent_view_product,

        ]);
    }

    //product details view
    function details($slug){
        $product_info = prodact::where('slug', $slug)->get();
        $similer_product = prodact::where('catagory_id',  $product_info->first()->catagory_id)->where('id', '!=',  $product_info->first()->id)->get();
        $thumbnails = thumbnail::where('prodact_id', $product_info->first()->id)->get();
        $available_color = inventory::where('prodact_id', $product_info->first()->id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')->get();
        $sizes = size::all();
        $colorss = color::all();
        $reviews = orderproduct::where('prodact_id', $product_info->first()->id)->whereNotNull('review')->get();
        $total_review = orderproduct::where('prodact_id',$product_info->first()->id)->whereNotNull('review')->count();
        $total_star = orderproduct::where('prodact_id', $product_info->first()->id)->whereNotNull('review')->sum('star');

        // cookis
        $product_id = $product_info->first()->id;
        $sl = Cookie::get('recent_view');
        if(!$sl){
            $sl = "[]";
        }
        $all_info = json_decode($sl, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $view_product = json_encode($all_info);
        Cookie::queue('recent_view', $view_product, 1000);

        return view('frontend.details',[
            'product_info'=>$product_info,
            'thumbnails'=>$thumbnails,
            'available_color'=>$available_color,
            'sizes'=>$sizes,
            'colorss'=>$colorss,
            'similer_product'=>$similer_product,
            'reviews'=>$reviews,
            'total_review'=>$total_review,
            'total_star'=>$total_star,
        ]);
    }

    // prodct size ajax url
    function getsize(Request $request){
        $sizes = inventory::where('prodact_id', $request->prodact_id)->where('color_id', $request->color_id)->get();
        $str = '';

        foreach($sizes as $size){
            $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size_id" id="'.$size->rel_to_size->id.'" value="'.$size->rel_to_size->id.'">
                        <label class="form-option-label" for="'.$size->rel_to_size->id.'">'.$size->rel_to_size->size_name.'</label>
                    </div>';
        }

        echo $str;
    }

    // customer login regestration
    function customer_reg_login(){
        return view('frontend.customer_reg_login');
    }



    // cart page view
    function cart(Request $request){
        $coupon = $request->coupon;
        $message = null;
        $type = '';


        if($coupon == ''){
            $discount = 0;

        }
        else{
            if(coupon::where('coupon_name', $coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') > coupon::where('coupon_name', $coupon)->first()->expired){
                    $discount = 0;
                    $message = 'Coupon Code Expire';
                }
                else{
                    $discount = coupon::where('coupon_name', $coupon)->first()->discount;
                    $type = coupon::where('coupon_name', $coupon)->first()->type;
                }
            }
            else{
                $discount = 0;
                $message = 'Invalid Coupon Code';
            }
        }


        $carts = card::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'discount'=>$discount,
            'message'=>$message,
            'type'=>$type,
        ]);
    }

    // category product view
    function catagory_product($catagory_id){
        $catagory= catagory::find($catagory_id);
        $categoru_product = prodact::where('catagory_id', $catagory_id)->paginate(3);
        return view('frontend.categoru_product', [
            'categoru_product'=>$categoru_product,
            'catagory'=>$catagory,
        ]);
    }

    // review
    function review_store(Request $request){
        orderproduct::where('customer_id', $request->customer_id)->where('prodact_id', $request->prodact_id)->update([
            'review'=>$request->review,
            'star'=>$request->star,
        ]);
        return back();
    }
}
