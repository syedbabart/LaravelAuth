<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    function login(){
        return view('auth.login');
    }

    function register(){
        return view('auth.register');
    }

    function save(Request $request){
        //validating requests
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:8|max:12',
            
            
        
        ]);

        //Insert data into database
       
        $admin = new Admin;
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->password= Hash::make($request->password);
        if ($request->isUser == 'on'){
            $admin->isUser=1;
        }else{
            $admin->isUser=0;
        }
        $admin->isActive=1;
        $save = $admin->save();

        if ($save){
            return back()->with('Success','New User has been successfully added to database');
        }else{
            return back()->with('Failure','Something went wrong. Please try again later!');
        }
        
    }

    function check(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8|max:12',
        ]);

        $userInfo = Admin::where('email', '=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if (Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                if($userInfo->isUser == 0){
                    return redirect('admin/dashboard');
                }
                if($userInfo->isUser == 1){
                    return redirect('user/dashboard');
                }
                
            }else{
                return back()->with('fail','Incorrect password!');
            }

        }
    }
    function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/auth/login');
        }


    }

    function dashboard(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.dashboard', $data);
    }

    function settings(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.settings', $data);
    }

    function profile(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.profile', $data);
    }

    function staff(){
        $users = Admin::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.staff', $data, ['users'=>$users]);
    }

    function userDashboard(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('user.dashboard', $data);
    }

    function userProfile(){
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('user.profile', $data);
    }

    function delete($id){
        $data=Admin::find($id);
        $data->delete();
        return redirect('admin/staff');
    }

    function getUserByID($id){
        $user = Admin::find($id);
        return response()->json($user);
    }

    function updateActiveStatus(Request $request){
        $user = Admin::find($request->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= $request->password;
        $user->isUser = $request->isUser;
        if ($request->isActive == 1){
            $user->isActive=0;
        }
        if ($request->isActive == 0){
            $user->isActive=1;
        }
        
        $user->save();
        
        return response()->json($user);

    }
}
