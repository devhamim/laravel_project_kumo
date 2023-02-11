<?php

namespace App\Http\Controllers;

use App\Models\catagory;
use App\Models\color;
use App\Models\order;
use App\Models\prodact;
use App\Models\shopbanner;
use App\Models\size;
use Illuminate\Http\Request;

class shopcontroller extends Controller
{
    //shop view
    function shop(Request $request){
        // search
        $data = $request->all();


        $based_on = 'updated_at';
        $order = 'DESC';
        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $based_on = 'prodact_name';
                $order = 'ASC';
            }
            elseif($data['sort'] == 2){
                $based_on = 'prodact_name';
                $order = 'DESC';
            }
            elseif($data['sort'] == 3){
                $based_on = 'after_discount';
                $order = 'DESC';
            }
            elseif($data['sort'] == 4){
                $based_on = 'after_discount';
                $order = 'ASC';
            }
            else{
                $based_on = 'updated_at';
                $order = 'DESC';
            }

        }

        $products = prodact::where(function($q) use ($data){
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('prodact_name', 'like', '%'.$data['q'].'%');
                    $q->orWhere('sort_desp', 'like', '%'.$data['q'].'%');
                    $q->orWhere('long_desp', 'like', '%'.$data['q'].'%');
                });
            }
            if(!empty($data['catagory_id']) && $data['catagory_id'] != '' && $data['catagory_id'] != 'undefined'){
                $q->where('catagory_id', $data['catagory_id']);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('rel_to_inventore', function ($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                        $q->whereHas('rel_to_color', function ($q) use ($data){
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                        $q->whereHas('rel_to_size', function ($q) use ($data){
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('after_discount', [$data['min'],$data['max']]);
            }


        })->orderBy($based_on, $order)->paginate(6)->withQueryString();

        // search product count
        $products_count = $products->count();



        $catagorys = catagory::all();
        $colors = color::all();
        $sizes = size::all();
        $shop_banner = shopbanner::all();
        return view('frontend.shop', [
            'products'=>$products,
            'catagorys'=>$catagorys,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'shop_banner'=>$shop_banner,
            'products_count'=>$products_count,
        ]);
    }
}
