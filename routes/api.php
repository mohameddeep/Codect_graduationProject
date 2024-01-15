<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RayController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HeartController;
use App\Http\Controllers\Api\OxygenController;
use App\Http\Controllers\Api\PressureController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['jwt.verify']], function() {

//x-ray route api
Route::post('/rays',[RayController::class,'store']);
Route::get('/rays',[RayController::class,'index']);
Route::get('/rays/{id}',[RayController::class,'show']);
Route::post('/rays/{id}',[RayController::class,'update']);
Route::delete('/rays/{id}',[RayController::class,'destroy']);

//pressure route api
Route::post('/pressure',[PressureController::class,'store']);
Route::get('/pressure',[PressureController::class,'index']);
Route::get('/pressure/{id}',[PressureController::class,'show']);
Route::post('/pressure/{id}',[PressureController::class,'update']);
Route::delete('/pressure/{id}',[PressureController::class,'destroy']);

//oxygen route api
Route::post('/oxygen',[OxygenController::class,'store']);
Route::get('/oxygen',[OxygenController::class,'index']);
Route::get('/oxygen/{id}',[OxygenController::class,'show']);
Route::post('/oxygen/{id}',[OxygenController::class,'update']);
Route::delete('/oxygen/{id}',[OxygenController::class,'destroy']);

//heartrate route api
Route::post('/heartrate',[HeartController::class,'store']);
Route::get('/heartrate',[HeartController::class,'index']);
Route::get('/heartrate/{id}',[HeartController::class,'show']);
Route::post('/heartrate/{id}',[HeartController::class,'update']);
Route::delete('/heartrate/{id}',[HeartController::class,'destroy']);

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    //Route::get('/user-profile', [UserController::class, 'userProfile']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});
