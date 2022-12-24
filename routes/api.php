<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ConsultationController;
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
//Public routes
Route::resource('consultations', ConsultationController::class);
Route::get('consultations/search/{name}', [ConsultationController::class, 'search']);
Route::get('consultations/showexpert/{id}', [ConsultationController::class, 'showexpert']);
Route::get(
    'consultations/showexperts/{id}',
    [
        ConsultationController::class, 'showexperts'
    ]
);

//middleware route for user
Route::middleware('auth:sanctum')->get('/user',[AuthController::class,'get_user']);
Route::middleware('auth:sanctum')->get('/logout',[AuthController::class,'logout']);
Route::middleware('auth:sanctum')->get('/info',function(){
   return response()->json(['data'=>\Illuminate\Support\Facades\Auth::user(),
   'message' => 'success'
   ]);
});


// Route::get('getFav',[Favourite::class, 'getFav']);
// Route::delete('deleteFav',[Favourite::class, 'deleteFav']);


//Public routes for user
Route::post('/auth/login',[AuthController::class,'login']);
Route::post('/auth/register_user',[AuthController::class,'create_user']);
Route::post('/auth/fav',[FavouriteController::class, 'makeFavouriteList']);


//middleware route for expert
Route::middleware('auth:sanctum')->get('expert/info',function(){
    return response()->json(['data'=>\Illuminate\Support\Facades\Auth::user(),
    'message' => 'success'
    ]);
 });
Route::middleware('auth:sanctum')->get('expert/showexperts',[ConsultationController::class,'showexperts']);
Route::middleware('auth:sanctum')->post('expert/consultations/assignconsultationtoexpert',
    [
    ConsultationController::class, 'assignconsultationtoexpert'
    ]
);


//Public routes for expert
Route::get('search/{name}',[ExpertAuthController::class, 'search']);

