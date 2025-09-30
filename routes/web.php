<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

Route::get('/', [TaskController::class, 'dashboard'])->name('main');

Route::get('/users/login', [UserController::class, 'login'])->name('login');
Route::post('/users/login', [UserController::class, 'loginSubmit'])->name('login.submit');

Route::get('/users/register', [UserController::class, 'create'])->name('register');
Route::post('/users/register', [UserController::class, 'store'])->name('register.store');

Route::post('/users/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/users/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/users/profile', [UserController::class, 'change'])->name('change');

Route::get('/users/admin', [UserController::class, 'users'])->name('users.all');

Route::get('users/modify/{id}', [UserController::class, 'modify'])->name('modify');
Route::post('users/modify/{id}', [UserController::class, 'modifySubmit'])->name('modifysubmit');

Route::post('users/status/{id}', [UserController::class, 'status'])->name('user.status');

//....................................................login.whit.google..................

Route::get('/google-login', [UserController::class, 'google_login'])->name('google_login');

Route::get('/login-with-google', [UserController::class, 'login_with_google']);

//....................................................login.eith.github..................

Route::get('/github-login', [UserController::class, 'github_login'])->name('github_login');

Route::get('/login-with-github', [UserController::class, 'login_with_github']);

//.......................................................................................

Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');

Route::get('/task/view/{id}', [TaskController::class, 'view'])->name('task.view');

Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('edit');
Route::post('/task/edit/{id}', [TaskController::class, 'editsubmit'])->name('editsubmit');

Route::get('/task/add', [TaskController::class, 'add'])->name('add');
Route::post('/task/add', [TaskController::class, 'addsubmit'])->name('addsubmit');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/board', [TaskController::class, 'board'])->name('board');

Route::get('/project-list', [TaskController::class, 'list'])->name('project');

Route::get('/download/{id}', [TaskController::class, 'webDownload'])->name('file.download');

Route::post('/task/{task}/comment', [CommentController::class, 'store'])->name('comment');

Route::post('task/done/{id}', [TaskController::class, 'done'])->name('done');

Route::get('/project/add', [TaskController::class, 'AddProject'])->name('AddProject');
Route::post('/project/add', [TaskController::class, 'AddProjectSubmit'])->name('AddProjectSubmit');

Route::get('/project/edit/{id}', [TaskController::class, 'EditProject'])->name('EditProject');
Route::post('/project/edit/{id}', [TaskController::class, 'EditProjectSubmit'])->name('EditProjectSubmit');

Route::get('/project/show/{id}', [TaskController::class, 'showProject'])->name('showProject');