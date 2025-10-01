<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

Route::get('/', [TaskController::class, 'dashboard'])->name('main');

//.......................................................................................

Route::group(['prefix' => 'users/'], function(){
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'loginSubmit'])->name('login.submit');
    
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('register.store');
    
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile', [UserController::class, 'change'])->name('change');
    
    Route::get('admin', [UserController::class, 'users'])->name('users.all');
    
    Route::get('modify/{id}', [UserController::class, 'modify'])->name('modify');
    Route::post('modify/{id}', [UserController::class, 'modifySubmit'])->name('modifysubmit');
    
    Route::post('status/{id}', [UserController::class, 'status'])->name('user.status');
});

//....................................................login.whit.google..................

Route::get('/google-login', [UserController::class, 'google_login'])->name('google_login');

Route::get('/login-with-google', [UserController::class, 'login_with_google']);

//....................................................login.eith.github..................

Route::get('/github-login', [UserController::class, 'github_login'])->name('github_login');

Route::get('/login-with-github', [UserController::class, 'login_with_github']);

//.......................................................................................


Route::group(['prefix' => 'task/'], function(){
    Route::get('view/{id}', [TaskController::class, 'view'])->name('task.view');
    
    Route::get('edit/{id}', [TaskController::class, 'edit'])->name('edit');
    Route::post('edit/{id}', [TaskController::class, 'editsubmit'])->name('editsubmit');
    
    Route::get('add', [TaskController::class, 'add'])->name('add');
    Route::post('add', [TaskController::class, 'addsubmit'])->name('addsubmit');
    
    Route::post('{task}/comment', CommentController::class)->name('comment');
    
    Route::post('done/{id}', [TaskController::class, 'done'])->name('done');
    
    Route::delete('{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::group(['prefix' => 'project/'], function(){
    Route::get('add', [TaskController::class, 'AddProject'])->name('AddProject');
    Route::post('add', [TaskController::class, 'AddProjectSubmit'])->name('AddProjectSubmit');
    
    Route::get('edit/{id}', [TaskController::class, 'EditProject'])->name('EditProject');
    Route::post('edit/{id}', [TaskController::class, 'EditProjectSubmit'])->name('EditProjectSubmit');
    
    Route::get('show/{id}', [TaskController::class, 'showProject'])->name('showProject');
});

Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

Route::get('/board', [TaskController::class, 'board'])->name('board');

Route::get('/project-list', [TaskController::class, 'list'])->name('project');

Route::get('/download/{id}', [TaskController::class, 'webDownload'])->name('file.download');

