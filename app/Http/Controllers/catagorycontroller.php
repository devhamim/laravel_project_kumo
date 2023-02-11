<?php

namespace App\Http\Controllers;

use App\Models\catagory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Str;


class catagorycontroller extends Controller
{
    // catagory strong user login block
    public function __construct()
    {
        $this->middleware('auth');
    }

    function catagorys(){
        $catagoris = catagory::all();
        return view('admin.catagory.catagory',[
            'catagoris'=>$catagoris,
        ]);
    }

    // catagory store
    function catagory_store(Request $request){
        $request->validate([
            'category_icon'=>'required',
            'catagory_name'=>'required',
            'catagory_img'=>'required|image|file|max:1000',
            // 'catagory_img'=>'image',
            // 'catagory_img'=>'file|max:1000',
        ],[
            'catagory_img.required'=>'image need',
        ]);
        $id= catagory::insertGetId([
            'catagory_name'=>$request->catagory_name,
            'category_icon'=>$request->category_icon,
            'addad_by'=>Auth::id(),
            'created_at'=>Carbon::now(),
        ]);

        $catagori_image = $request->catagory_img;
        $extension = $catagori_image->getClientOriginalExtension();
        // $file_name = $id.'.'.$extension;
        $file_name = Str::random(5). rand(1000,999999).'.'.$extension;
        $img = Image::make($catagori_image)->resize(300, 200)->save(public_path('uplodes/catagory_img/'.$file_name));

        catagory::find($id)->update([
            'catagory_img'=>$file_name ,
        ]);

        return back()->with('success','catagory add successfully');
    }

    // soft Delete

    function catagory_delete($catagoris_id){
        catagory::find($catagoris_id)->delete();
        return back()->with('success_delete','Catagoru Delete Successfully');

    }

    // edit
    function catagory_edit($catagoris_id){
        $catagori_info = catagory::find($catagoris_id);
        return view('admin.catagory.edit', [
            'catagori_info'=>$catagori_info,
        ]);
    }

    // catagory update
    function catagory_update(request $request){
        if($request->catagory_img == ''){
            catagory::find($request->catagoris_id)->update([
                'catagory_name'=>$request->catagory_name,
            ]);
            return back();
        }
        else{
            $request->validate([
                'catagory_name'=>'required',
                'catagory_img'=>'required|image|file|max:1000',
                // 'catagory_img'=>'image',
                // 'catagory_img'=>'file|max:1000',
            ],[
                'catagory_img.required'=>'image need',
            ]);

            $image = catagory::where('id',$request->catagoris_id)->first()->catagory_img;
            $image_delete = public_path('uplodes/catagory_img/'.$image);
            unlink($image_delete);


            $catagori_image = $request->catagory_img;
            $extension = $catagori_image->getClientOriginalExtension();
            $file_name = Str::random(5). rand(1000,999999).'.'.$extension;
            $img = Image::make($catagori_image)->resize(300, 200)->save(public_path('uplodes/catagory_img/'.$file_name));

            catagory::find($request->catagoris_id)->update([
                'catagory_name'=>$request->catagory_name,
                'catagory_img'=>$file_name,
            ]);
            return back();
        }
    }


    // restore catagory
    function catagory_restore($catagoris_id){
        catagory::onlyTrashed()->find($catagoris_id)->restore();
        return back()->with('success_restore','Catagory Restore Successfully');
    }


    // hard delete catagory
    function catagory_hard_delete($catagoris_id){
        $image = catagory::onlyTrashed()->where('id',$catagoris_id)->first()->catagory_img;
        $image_delete = public_path('uplodes/catagory_img/'.$image);
        unlink($image_delete);

        catagory::onlyTrashed()->find($catagoris_id)->forceDelete();
        return back()->with('success_delete','Catagory Delete Successfully');
    }


    // catagory trash
    function catagory_trash(){
        $catagory= catagory::all();
        $catagory_trash= catagory::onlyTrashed()->get();
        return view('admin\catagory\catagory_trash',[
            'catagory'=>$catagory,
            'catagory_trash'=>$catagory_trash,
        ]);
    }
}
