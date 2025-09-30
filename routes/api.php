<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/


Route::post('/users/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function() 
{
    Route::get('/users', [UserApiController::class, 'users']);
    
    Route::post('/users/register', [UserApiController::class, 'register']);
    
    Route::post('/users/logout', [UserApiController::class, 'logout']);
    
    Route::post('/users/profile', [UserApiController::class, 'change']);
    
    //.............................................................................
    
    Route::get('/task', [TaskApiController::class, 'index']);
    
    Route::get('/task/show/{id}', [TaskApiController::class, 'show'])->name('show');
    
    Route::post('/task/edit/{id}', [TaskApiController::class, 'editSubmit'])->name('editSubmit');
    
    Route::post('/task/add', [TaskApiController::class, 'store']);

    Route::get('/download/{id}', [TaskApiController::class, 'download']);

});

