<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


//Protecting Routes
//Route::group(['middleware' => ['auth:sanctum']], function () {
    /* Route::get('v1/create', function(Request $request) {
        return auth()->user();
    }); */

    // API route for logout user
    //Route::post('/logout', [App\Http\Controllers\api\v1\AdminController::class, 'logout']);
//});
Route::post('v1/admin/login',[App\Http\Controllers\api\v1\AdminController::class, 'login']);

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1','middleware'=>['auth:sanctum','admin']], function () {
    Route::post('/admin/create',[App\Http\Controllers\api\v1\AdminController::class, 'register']);
    Route::post('admin/logout',[App\Http\Controllers\api\v1\AdminController::class, 'logout']);
    Route::get('admin/user-listing',[App\Http\Controllers\api\v1\AdminController::class, 'index']);
    Route::put('admin/user-edit/{uuid}',[App\Http\Controllers\api\v1\AdminController::class, 'edit']);
    Route::delete('admin/user-delete/{uuid}',[App\Http\Controllers\api\v1\AdminController::class, 'destroy']); 
  });
 //Token:3|0F6uA3DU3lIxzwFmKBpROZxOPc4jVeRjovjcySwN

 Route::post('v1/user/login',[App\Http\Controllers\api\v1\UserController::class, 'login']);

 
 Route::post('user/forgot-password ',[App\Http\Controllers\api\v1\UserController::class, 'forgotPassword']);

    Route::group(['prefix' => 'v1', 'namespace' => 'api\v1','middleware'=>['auth:sanctum']], function () {
    Route::post('/user',[App\Http\Controllers\api\v1\UserController::class, 'index']);
    Route::delete('user/',[App\Http\Controllers\api\v1\UserController::class, 'destroy']);
    Route::post('user/logout',[App\Http\Controllers\api\v1\AdminController::class, 'logout']);
    //I could not understand above two routes
    Route::get('user/orders',[App\Http\Controllers\api\v1\UserController::class, 'orders']);
    Route::post('user/create',[App\Http\Controllers\api\v1\UserController::class, 'create']);
    //Could not understand above route what user will create
    Route::post('user/reset-password-token',[App\Http\Controllers\api\v1\UserController::class, 'resetPasswordToken']);
   
    Route::post('user/edit',[App\Http\Controllers\api\v1\UserController::class, 'edit']);
   
 
  });

 

    Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
          Route::get('main/blog',[App\Http\Controllers\api\v1\MainController::class, 'index']);
          Route::get('main/blog/{uuid}',[App\Http\Controllers\api\v1\MainController::class, 'single']);
          Route::get('main/promotions',[App\Http\Controllers\api\v1\MainController::class, 'promotionIndex']);


  });