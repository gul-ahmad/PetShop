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


Route::group(['prefix' => 'v1', 'namespace' => 'api\v1','middleware'=>['auth:sanctum','admin']], function () {
    Route::post('/admin/create',[App\Http\Controllers\api\v1\AdminController::class, 'register']);
    Route::post('admin/login',[App\Http\Controllers\api\v1\AdminController::class, 'login']);
    Route::post('admin/logout',[App\Http\Controllers\api\v1\AdminController::class, 'logout']);
    Route::get('admin/user-listing',[App\Http\Controllers\api\v1\AdminController::class, 'index']);
    Route::put('admin/user-edit/{uuid}',[App\Http\Controllers\api\v1\AdminController::class, 'edit']);
    Route::delete('admin/user-delete/{uuid}',[App\Http\Controllers\api\v1\AdminController::class, 'destroy']); 
  });
 //Token:3|0F6uA3DU3lIxzwFmKBpROZxOPc4jVeRjovjcySwN