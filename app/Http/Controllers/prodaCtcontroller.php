<?php

namespace App\Http\Controllers;

use App\Models\catagory;
use App\Models\color;
use App\Models\inventory;
use App\Models\prodact;
use App\Models\size;
use App\Models\subcatagory;
use App\Models\thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;
use PhpParser\Parser\Multiple;

class prodaCtcontroller extends Controller
{

// user login block
public function __construct()
{
    $this->middleware('auth');
}


    function prodact(){
        $catagorys = catagory::all();
        $subcatagorys = subcatagory::all();
        return view('admin.prodact.add_prodact',[
            'catagorys'=>$catagorys,
            'subcatagorys'=>$subcatagorys,
        ]);
    }

    // catagory subcatagory select
    function getsubcatagory(Request $request){
        $subcatagorys = subcatagory::where('catagory_id', $request->catagory_id)->get();
        $str = '<option value="">-- Select Subcatagory --</option>';
        foreach($subcatagorys as $subcatagory){
            $str .= '<option value="'. $subcatagory->id .'">' .$subcatagory->subcatagory_name .'</option>';
        }
        echo $str;
    }

    // prodact store
    function prodact_store(Request $request){
        $prodact_id = prodact::insertGetId([
            'catagory_id'=> $request->catagory_id,
            'subcatagory_id'=> $request->subcatagory_id,
            'prodact_name'=> $request->prodact_name,
            'price'=> $request->price,
            'discount'=> $request->discount,
            'after_discount'=> $request->price - ($request->price*$request->discount/100),
            'prodact_brand'=> $request->prodact_brand,
            'sort_desp'=> $request->sort_desp,
            'long_desp'=> $request->long_desp,
            'slug'=> Str::lower(str_replace(' ', '-', $request->prodact_name)). '-'. rand(0, 100000000),

        ]);

        $preview_image = $request->preview;
        $extension = $preview_image->getClientOriginalExtension();
        $file_name = Str::random(5). rand(1000,999999).'.'.$extension;
        Image::make($preview_image)->resize(450, 450)->save(public_path('uplodes/prodact/preview/'.$file_name));

        prodact::find($prodact_id)->update([
            'preview'=>$file_name,
        ]);
            // thumbnail store
        foreach($request->thumbnail as $thumbnail){
            $extension = $thumbnail->getClientOriginalExtension();
            $file_name = Str::random(5). rand(1000,999999). '.' .$extension;
            Image::make($thumbnail)->resize(450, 450)->save(public_path('uplodes/prodact/thumbnail/'.$file_name));

            thumbnail::insert([
                'prodact_id'=>$prodact_id,
                'thumbnail'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);

        }
        return back()->with('success', 'Product Add Successfully');
    }


    // prodact list page view
    function prodact_list(){
        $prodacts = prodact::all();
        return view('admin.prodact.prodact', [
            'prodacts'=>$prodacts,
        ]);
    }

    // product delete
    function prodact_delete($prodact_id){
        $image = prodact::where('id', $prodact_id)->first()->preview;
        $image_delete = public_path('uplodes/prodact/preview/'. $image);
        unlink($image_delete);

        // Multiple image delete
        $thumbnails = thumbnail::where('prodact_id', $prodact_id)->get();
        foreach($thumbnails as $thumb){
            $thumbnail_img = thumbnail::where('id', $thumb->id)->first()->thumbnail;
            $thumbnail_delete = public_path('uplodes/prodact/thumbnail/'. $thumbnail_img);
            unlink($thumbnail_delete);

            thumbnail::find($thumb->id)->delete();
        }


        prodact::find($prodact_id)->delete();
        return back()->with('delete_success', 'Product Delete Successfully');
    }

    // product color
    function variation(){
        $colors = color::all();
        $sizes = size::all();
        return view('admin.prodact.variation', [
            'colors'=> $colors,
            'sizes'=> $sizes,
        ]);
    }

    // prodact variation store
    function variation_store(request $request){
        if($request->btn == 1){
            color::insert([
                'color_name'=> $request->color_name,
                'color_code'=> $request->color_code,
            ]);
            return back()->with('success', 'Color Add Successfully');
        }
        else{
            size::insert([
                'size_name'=>$request->size_name,
            ]);
            return back()->with('success_size', 'Size Add Successfully');
        }
    }

    // prodact inventory
    function prodact_inventory($prodact_id){
        $colors = color::all();
        $sizes = size::all();
        $prodact_info = prodact::find($prodact_id);
        $inventoryes = inventory::where('prodact_id', $prodact_id)->get();
        return view('admin.prodact.inventory', [
            'colors'=> $colors,
            'sizes'=> $sizes,
            'prodact_info'=>$prodact_info,
            'inventoryes'=>$inventoryes,
        ]);
    }

    // product inventroy store
    function inventory_store(Request $request){
        inventory::insert([
            'prodact_id'=> $request->prodact_id,
            'color_id'=> $request->color_id,
            'size_id'=> $request->size_id,
            'quantity'=> $request->quantity,
        ]);

        return back()->with('success_invn', 'Inventory Add Successfully');
    }

}
