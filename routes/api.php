<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AdminController;
use App\Http\Controllers\api\v1\BrandsController;

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
    Route::get('user/orders',[App\Http\Controllers\api\v1\UserController::class, 'userOrders']);
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

  Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
       Route::get('brand',[App\Http\Controllers\api\v1\BrandController::class, 'index']); 
       Route::post('brand/create',[App\Http\Controllers\api\v1\BrandController::class, 'store']);
       Route::put('brand/update/{uuid}',[App\Http\Controllers\api\v1\BrandController::class, 'update']);
       Route::delete('brand/{uuid}',[App\Http\Controllers\api\v1\BrandController::class, 'destroy']); 

});

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
    Route::get('categories',[App\Http\Controllers\api\v1\CategoryController::class, 'index']); 
    Route::post('category/create',[App\Http\Controllers\api\v1\CategoryController::class, 'store']);
    Route::put('category/update/{uuid}',[App\Http\Controllers\api\v1\CategoryController::class, 'update']);
    Route::delete('category/{uuid}',[App\Http\Controllers\api\v1\CategoryController::class, 'destroy']); 

});

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
    Route::get('product',[App\Http\Controllers\api\v1\ProductController::class, 'index']); 
    Route::post('product/create',[App\Http\Controllers\api\v1\ProductController::class, 'store']);
    Route::put('product/update/{id}',[App\Http\Controllers\api\v1\ProductController::class, 'update']);
    Route::delete('product/{id}',[App\Http\Controllers\api\v1\ProductController::class, 'destroy']); 

});
Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
    Route::get('order-status',[App\Http\Controllers\api\v1\OrderStatusController::class, 'index']); 
    Route::post('order-status/create',[App\Http\Controllers\api\v1\OrderStatusController::class, 'store']);
    Route::put('order-status/update/{uuid}',[App\Http\Controllers\api\v1\OrderStatusController::class, 'update']);
    Route::delete('order-status/{uuid}',[App\Http\Controllers\api\v1\OrderStatusController::class, 'destroy']); 

});

Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
  
    Route::get('payments',[App\Http\Controllers\api\v1\PaymentController::class, 'index']); 
    Route::post('payments/create',[App\Http\Controllers\api\v1\PaymentController::class, 'store']);
    Route::put('payments/update/{uuid}',[App\Http\Controllers\api\v1\PaymentController::class, 'update']);
    Route::delete('payments/{uuid}',[App\Http\Controllers\api\v1\PaymentController::class,'destroy']); 

});
 //Pending 
Route::group(['prefix' => 'v1', 'namespace' => 'api\v1','middleware'=>['auth:sanctum']], function () {
  
    Route::get('orders',[App\Http\Controllers\api\v1\OrderController::class, 'index']); 
    Route::post('order/create',[App\Http\Controllers\api\v1\OrderController::class, 'store']);
    Route::get('order/{uuid}',[App\Http\Controllers\api\v1\OrderController::class, 'show']); 
    Route::put('order/{uuid}',[App\Http\Controllers\api\v1\OrderController::class, 'update']);
     Route::delete('order/{uuid}',[App\Http\Controllers\api\v1\OrderController::class,'destroy']);
     Route::get('orders/dashboard',[App\Http\Controllers\api\v1\OrderController::class, 'dashboard']); 
     Route::get('order/{uuid}/download',[App\Http\Controllers\api\v1\OrderController::class, 'download']);   

});