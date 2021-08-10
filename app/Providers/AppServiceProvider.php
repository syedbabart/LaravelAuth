<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        
        view()->composer(['adminNavBar.master', 'admin.staff', 'admin.settings'], function($view) {
            $roles = array();
            $users_roles = array();
            $userInfo = User::where('id','=', session('LoggedUser'))->first();

            foreach($userInfo->roles as $role){
                $pivot = $role->pivot;
                array_push($roles, $pivot);
            }
            foreach($roles as $idse){
                $x = Role::where('id','=',$idse->role_id)->first();
                array_push($users_roles, $x);
            }
                 
            $user_priveleges = ['canAddUser' => False, 'canDeleteUser' => False, 'canChangeStatus' => False, 'canManageRoles' => False];
            foreach($users_roles as $ur){
                if ($ur->canAddUser){
                    $user_priveleges['canAddUser'] = True;
                }
                if ($ur->canDeleteUser){
                    $user_priveleges['canDeleteUser'] = True;
                }
                if ($ur->canChangeStatus){
                    $user_priveleges['canChangeStatus'] = True;
                }
                if ($ur->canManageRoles){
                    $user_priveleges['canManageRoles'] = True;
                }
            }
            $view->with(['user_priveleges' => $user_priveleges]);
            
        });
        
    }
}
