<?php

namespace App\Http\Controllers;

use App\Models\catagory;
use App\Models\subcatagory;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
use Image;
use Str;

class subcatagorycontroller extends Controller
{
// user login block
public function __construct()
{
    $this->middleware('auth');
}

    // subcatagory store
    function subcatagory(){
        $catagories = catagory::all();
        $subcatagories = subcatagory::all();
        return view('admin.subcatagory.subcatagory',[
            'catagories'=>$catagories,
            'subcatagories'=>$subcatagories,
        ]);
    }


    // subcatagory insart
    function subcatagory_store(request $request){
        $request->validate([
            'subcatagory_name'=>'required',
            'subcatagory_img'=>'required|image|file|max:1000'
        ]);
        $id = subcatagory::insertGetId([
            'catagory_id' => $request->catagory_id,
            'subcatagory_name' => $request->subcatagory_name,
        ]);
        $subcatagori_image = $request->subcatagory_img;
        $extension = $subcatagori_image->getClientOriginalExtension();
        // $file_name = $id.'.'.$extension;
        $file_name = Str::random(5). rand(1000,999999).'.'.$extension;
        $img = Image::make($subcatagori_image)->resize(300, 200)->save(public_path('uplodes/subcatagory/'.$file_name));

        subcatagory::find($id)->update([
            'subcatagory_img'=>$file_name ,
        ]);

        return back()->with('success','Subcatagory add successfully');
    }


     // soft Delete

     function subcatagory_delete($subcatagoris_id){
        subcatagory::find($subcatagoris_id)->delete();
        return back()->with('success_delete','Subcatagoru Delete Successfully');
    }

    // edit
    function subcatagory_edit($subcatagoris_id){
        $catagories = catagory::all();
        $subcatagori_info = subcatagory::find($subcatagoris_id);
        return view('admin.subcatagory.sub_edit', [
            'subcatagori_info'=>$subcatagori_info,
            'catagories'=>$catagories,
        ]);
    }


    // subcatagory trash
    function subcatagory_trash(){
        $subcatagory= subcatagory::all();
        $subcatagory_trash= subcatagory::onlyTrashed()->get();
        return view('admin.subcatagory.subcatagory_trash',[
            'catagory'=>$subcatagory,
            'subcatagory_trash'=>$subcatagory_trash,
        ]);
    }

    // subcatagory hard delete
    function subcatagory_hard_delete($subcatagoris_id){
        $image =  subcatagory::onlyTrashed()->where('id', $subcatagoris_id)->first()->subcatagory_img;
        $image_delete = public_path('uplodes/subcatagory/'.$image);
        unlink($image_delete);

        subcatagory::onlyTrashed()->find($subcatagoris_id)->forceDelete();
        return back()->with('success_delete', 'Delete Successfully');
    }

    // subcatagory restore
    function subcatagory_restore($subcatagoris_id){
        subcatagory::onlyTrashed()->find($subcatagoris_id)->restore();
        return back()->with('restore', 'Subcatagory Restore');
    }

    // subcatagory update
    function subcatagory_update(Request $request){
        $request->validate([
            'catagory_id'=> 'required',
            'subcatagory_name'=> 'required',
        ]);
        if($request->subcatagory_img == ''){
            subcatagory::find($request->id)->update([
                'catagory_id'=> $request->catagory_id,
                'subcatagory_name'=> $request->subcatagory_name,
            ]);
            return back()->with('success_update','Update Successfully');

        }
        else{
            $request->validate([
                'catagory_id'=> 'required',
                'subcatagory_name'=> 'required',
                'subcatagory_img'=> 'required|image|file|max:1000',
            ]);
            $image = subcatagory::where('id', $request->id)->first()->subcatagory_img;
            $image_delete = public_path('uplodes/subcatagory/'. $image);
            unlink($image_delete);

            $uplode_file = $request->subcatagory_img;
            $extension = $uplode_file->getClientOriginalExtension();
            $file_name = Str::random(5). rand(1000,999999).'.'.$extension;
            Image::make($uplode_file)->resize(300, 200)->save(public_path('uplodes/subcatagory/'.$file_name));

            subcatagory::find($request->id)->update([
                'catagory_id'=> $request->catagory_id,
                'subcatagory_name'=> $request->subcatagory_name,
                'subcatagory_img'=> $file_name,
            ]);
            return back()->with('success_update','Update Successfully');
        }
    }


}
