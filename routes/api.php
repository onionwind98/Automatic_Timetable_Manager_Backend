<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authenticationController;

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
    Route::get('/logout', [authenticationController::class,'logout']);

});
// Route::group(['middleware' => ['auth:sanctum']], function () {
//     // return $request->user();
//     Route::get('/logout', [authenticationController::class,'logout']);
    
// });

Route::post('/login', [authenticationController::class,'login']);
Route::post('/register', [authenticationController::class,'register']);