<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/auth/save',[MainController::class, 'save'])->name('auth.save');
Route::post('/auth/check',[MainController::class,'check'])->name('auth.check');
Route::get('/auth/logout',[MainController::class,'logout'])->name('auth.logout');




Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('/auth/login',[MainController::class, 'login'])->name('auth.login');
    Route::get('/auth/register',[MainController::class, 'register'])->name('auth.register');
    Route::get('/admin/dashboard', [MainController::class, 'dashboard']);
    Route::get('/admin/profile', [MainController::class, 'profile']);
    Route::get('/admin/settings', [MainController::class, 'settings']);
    Route::get('/admin/staff', [MainController::class, 'staff']);
    Route::get('/admin/createNewRole', [MainController::class, 'createNewRole'])->name('CreateNewRole');
    Route::get('/admin/delete/{id}', [MainController::class, 'delete']);
    Route::get('/admin/makeManager/{id}', [MainController::class, 'makeManager']);
    Route::get('/admin/makeAdmin/{id}', [MainController::class, 'makeAdmin']);
    Route::get('/admin/revokeManager/{id}', [MainController::class, 'revokeManager']);
    Route::get('/admin/revokeAdmin/{id}', [MainController::class, 'revokeAdmin']);
    Route::get('/admin/{id}', [MainController::class, 'getUserByID']);
    Route::put('/admin', [MainController::class, 'updateActiveStatus'])->name('activeStatus.update');
    Route::get('/user/dashboard', [MainController::class, 'userDashboard']);
    Route::get('/user/profile', [MainController::class, 'userProfile']);
    Route::get('/manager/dashboard', [MainController::class, 'managerDashboard']);
    Route::get('/manager/profile', [MainController::class, 'managerProfile']);
    Route::get('/manager/staff', [MainController::class, 'managerStaff']);
});
