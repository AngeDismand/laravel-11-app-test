<?php

use App\Http\Controllers\RecruitmentContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/recruitment/add', 'pages.add');
Route::view('/login', 'login.login');
Route::view('/logout', 'login.logout');
Route::view('/register', 'register.register');
Route::get('/dashboard', function (){
    return view('dashboard.dashboard');
});
Route::get('/home', function (){
    return view('home.home');
});
Route::get('/dashboard/create', function (){
    return view('dashboard.create');
});

Route::resource('/recruitment',RecruitmentContoller::class);