<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\UserRoles;
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
        $admin->isActive=1;
        $save = $admin->save();

        
        //create a 'User' role for every new incoming user
        $role = new UserRoles;
        $role->user_id = $admin->id;
        $role->role_id = 3;
        $save_user = $role->save();

        if ($admin->id == 1){       //create an 'Admin' role for first user which signs up
            $role = new UserRoles;
            $role->user_id = $admin->id;
            $role->role_id = 1;
            $save_admin = $role->save();
        }


        if ($save && $save_user){
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
                $isAdmin = UserRoles::where(['user_id'=>$userInfo->id, 'role_id'=>1])->first();
                $isManager = UserRoles::where(['user_id'=>$userInfo->id, 'role_id'=>2])->first();
                
                    if ($userInfo->isActive == 0){
                        return back()->with('fail','Your account is currently inactive.');
                    }
                    if($isAdmin){
                        return redirect('/admin/dashboard');
                    }elseif($isManager){
                        return redirect('/manager/dashboard');
                    }else{
                        return redirect('/user/dashboard');
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
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.dashboard', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function settings(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.settings', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function profile(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.profile', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function staff(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('admin.staff', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function userDashboard(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('user.dashboard', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function userProfile(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('user.profile', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function managerDashboard(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('manager.dashboard', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function managerProfile(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('manager.profile', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function managerStaff(){
        $users = Admin::all();
        $user_roles = UserRoles::all();
        $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
        return view('manager.staff', $data, ['users'=>$users])->with(compact('user_roles', $user_roles));
    }

    function delete($id){
        $data=Admin::find($id);
        $data->delete();
        $user_roles=UserRoles::where('user_id','=',$id);
        $user_roles->delete();
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
        if ($request->isActive == 1){
            $user->isActive=0;
        }
        if ($request->isActive == 0){
            $user->isActive=1;
        }
        $user->save();
        
        return response()->json($user);

    }

    function makeManager($id){
        $data=Admin::find($id);
        $role = new UserRoles;
        $role->user_id = $data->id;
        $role->role_id = 2;
        $save_user = $role->save();
        return redirect('admin/staff');
    }

    function makeAdmin($id){
        $data=Admin::find($id);
        $role = new UserRoles;
        $role->user_id = $data->id;
        $role->role_id = 1;
        $save_user = $role->save();
        return redirect('admin/staff');
    }

    function revokeAdmin($id){
        $data=Admin::find($id);
        $admin_role=UserRoles::where(['user_id'=>$data->id, 'role_id'=>1]);
        $admin_role->delete();
        return redirect('admin/staff');
    }

    function revokeManager($id){
        $data=Admin::find($id);
        $manager_role=UserRoles::where(['user_id'=>$data->id, 'role_id'=>2]);
        $manager_role->delete();
        return redirect('admin/staff');
    }

    function addUsers(){
        return view('admin.addNewUsers');
    }

    function addNewUsers(Request $request){
        $data=$request->all();
        
    }
}