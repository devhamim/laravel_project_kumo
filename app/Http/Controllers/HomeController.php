<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

// use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // user login block
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }
    // user view/count
    function users(){
        $users = User::where('id','!=', auth::id())->get();
        $total_count = User::count();
        return view('admin.users.user', compact('users','total_count'));
    }

    // user delete
    function users_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('success','User Delete Successfully');
    }

  // profile view
  function profile(){
    return view('admin.users.profile');
    }

    // profile edit
    function profile_edit(){
        return view('admin.users.profile_edit');
    }

    // profile update
    function profile_update(request $request){
        user::find(Auth::id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
            return back();

        // $request -> validate([
        //     'password'=>Password::min(8)
        //     ->letters()
        //     ->mixedCase()
        //     ->numbers()
        //     ->symbols()
        //     ->uncompromised()
        // ]);

        // if($request->password==''){
        //     user::find(Auth::id())->update([
        //         'name'=>$request->name,
        //         'email'=>$request->email,
        //     ]);
        //     return back();
        // }
        // else{
        //     user::find(Auth::id())->update([
        //         'name'=>$request->name,
        //         'email'=>$request->email,
        //         'password'=>bcrypt($request->password),
        //     ]);
        //     return back();
        // }
    }

    // profile password update
    function profile_password_update(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);
        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('confirm_password', 'Password Update');
        }
        else{
            return back()->with('old_password', 'old password wrong');
        }
    }

    // profile avetar
    function photo_update(Request $request){
        $photo = Auth::user()->photo;
        if ($photo == null) {
            $uplode_photo = $request->photo;
            $extension = $uplode_photo->getClientOriginalExtension();
            $file_name = Auth::id(). '.' .$extension;

            Image::make($uplode_photo)->save(public_path('uplodes/profile/'.$file_name));
            user::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back()->with('photo_uplode', 'Profile Photo Uplode');
        }
        else{
            $delete_photo = public_path('uplodes/profile/'.$photo);
            unlink($delete_photo);

            $uplode_photo = $request->photo;
            $extension = $uplode_photo->getClientOriginalExtension();
            $file_name = Auth::id(). '.' .$extension;

            Image::make($uplode_photo)->save(public_path('uplodes/profile/'.$file_name));
            user::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back()->with('photo_update', 'Profile Photo Update');
        }
    }

    // user logout
    function user_logout(){
        Auth::logout();
        return redirect('/login');
    }

}
