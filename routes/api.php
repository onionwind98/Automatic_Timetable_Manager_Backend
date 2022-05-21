<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authenticationController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\timetableController;
use App\Http\Controllers\testController;
use App\Http\Controllers\timeslotController;


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

// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    // return $request->user();
    Route::get('/logout', [authenticationController::class,'logout']);
    Route::post('/changeEmail', [authenticationController::class,'changeEmail']);
    Route::post('/changePassword', [authenticationController::class,'changePassword']);

    Route::post('/addTask', [taskController::class,'addTask']);
    Route::post('/editTask', [taskController::class,'editTask']);
    Route::post('/viewTaskEdit', [taskController::class,'viewTaskEdit']);
    Route::post('/getUnassignedTask', [taskController::class,'getUnassignedTask']);
    Route::post('/getOngoingTask', [taskController::class,'getOngoingTask']);
    Route::post('/getHistoryTask', [taskController::class,'getHistoryTask']);
    Route::post('/getTodaySchedule', [taskController::class,'getTodaySchedule']);
    Route::post('/deleteTask', [taskController::class,'deleteTask']);
    Route::post('/removeTaskFromTimetable', [taskController::class,'removeTaskFromTimetable']);
    // Route::post('/updateTaskStatus', [taskController::class,'updateTaskStatus']);
    Route::post('/updateListOfTaskStatus', [taskController::class,'updateListOfTaskStatus']);

    Route::post('/addToTimetable', [timetableController::class,'addToTimetable']);
    Route::post('/getWeeklyTimetable', [timetableController::class,'getWeeklyTimetable']);
    Route::post('/getDailyTimetable', [timetableController::class,'getDailyTimetable']);

    Route::get('/getTimeslot', [timeslotController::class,'getTimeslot']);

});

Route::post('/login', [authenticationController::class,'login']);
Route::post('/register', [authenticationController::class,'register']);
Route::post('/forgetPassword', [authenticationController::class,'forgetPassword']);
Route::post('/checkEmail', [authenticationController::class,'checkEmail']);

Route::post('/test', [testController::class,'test']);

