<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function save(Request $request){
        //validating requests
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8|max:12',
            
        ]);

        //Insert data into database
       
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->isActive=1;
        $save = $user->save();

        
        //create a 'User' role for every new incoming user
        $role = new UserRole;
        $role->user_id = $user->id;
        $role->role_id = 3;
        $save_user = $role->save();

        if ($user->id == 1){       //create an 'Admin' role for first user which signs up
            $role = new UserRole;
            $role->user_id = $user->id;
            $role->role_id = 1;
            $save_admin = $role->save();
        }


        if ($save && $save_user){
            return back()->with('Success','New User has been successfully added to database');
        }else{
            return back()->with('Failure','Something went wrong. Please try again later!');
        }
        
    }

    public function check(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8|max:12',
        ]);

        $userInfo = User::where('email', '=', $request->email)->first();


        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            //check password
            if (Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                
                if ($userInfo->isActive == 0){
                    return back()->with('fail','Your account is currently inactive.');
                }
                
                return redirect('/admin/dashboard');
 
            }else{
                return back()->with('fail','Incorrect password!');
            }

        }
    }

    public function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/auth/login');
        }
    }

    public function dashboard(){
        $roles=Role::all();
        $user_roles = UserRole::all();
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        return view('admin.dashboard', $data, ['roles'=>$roles])->with(compact('user_roles', $user_roles));
    }

    public function settings(){
        $roles=Role::all();
        $user_roles = UserRole::all();
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        return view('admin.settings', $data, ['roles'=>$roles])->with(compact('user_roles', $user_roles));
    }

    public function profile(){
        $roles=Role::all();
        $user_roles = UserRole::all();
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        return view('admin.profile', $data, ['roles'=>$roles])->with(compact('user_roles', $user_roles));
    }

    public function staff(){
        $users = User::all();
        $roles=Role::all();
        $user_roles = UserRole::all();
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        return view('admin.staff', $data, ['users'=>$users])->with(compact('user_roles', $user_roles))->with('roles', $roles);
    }

    public function delete($id){
        $data=User::find($id);
        $data->delete();
        $user_roles=UserRole::where('user_id','=',$id);
        $user_roles->delete();
        return redirect('admin/staff');
    }

    public function getUserByID($id){
        $user = User::find($id);
        return response()->json($user);
    }

    public function updateActiveStatus(Request $request){
        $user = User::find($request->id);
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

    public function makeManager($id){
        $data=User::find($id);
        $role = new UserRole;
        $role->user_id = $data->id;
        $role->role_id = 2;
        $save_user = $role->save();
        return redirect('admin/staff');
    }

    public function makeAdmin($id){
        $data=User::find($id);
        $role = new UserRole;
        $role->user_id = $data->id;
        $role->role_id = 1;
        $save_user = $role->save();
        return redirect('admin/staff');
    }

    public function revokeAdmin($id){
        $data=User::find($id);
        $admin_role=UserRole::where(['user_id'=>$data->id, 'role_id'=>1]);
        $admin_role->delete();
        return redirect('admin/staff');
    }

    public function revokeManager($id){
        $data=User::find($id);
        $manager_role=UserRole::where(['user_id'=>$data->id, 'role_id'=>2]);
        $manager_role->delete();
        return redirect('admin/staff');
    }

    public function addUsers(){
        return view('admin.addNewUsers');
    }

    public function addNewUsers(Request $request){

        if (count($request->emails) > 0){
            $count = count($request->emails);
            $data_to_add = array();
            $i=0;
            while($i < $count){
                $data=array(
                    'name'=>$request->user_names[$i],
                    'email'=>$request->emails[$i],
                    'password'=>Hash::make($request->passwords[$i]),
                    'isActive'=>1,
                );
                array_push($data_to_add, $data);
                $i+=1;
            }
            User::insert($data_to_add);
        }
        return redirect('/admin/staff');

    }

    public function addRole(){
        return view('admin.addNewRole');
    }

    public function addNewRole(Request $request){
        $new_role = new Role;
        $new_role->roleName = $request->roleName;
        $new_role->canAddUser=0;
        $new_role->canDeleteUser=0;
        $new_role->canChangeStatus=0;
        $new_role->canManageRoles=0;

        if($request->canAddUser){
            $new_role->canAddUser = 1;
        }
        if($request->canDeleteUser){
            $new_role->canDeleteUser = 1;
        }
        
        if($request->canChangeStatus){
            $new_role->canChangeStatus = 1;
        }

        if($request->canManageRoles){
            $new_role->canManageRoles = 1;
        }
        $new_role->save();
        return redirect('/admin/settings');

    }
}