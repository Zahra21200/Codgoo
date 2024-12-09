<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthenticationController as AdminAuth;
use App\Http\Controllers\Client\AuthenticationController as ClientAuth;


Route::get('/', function () {
    return view('welcome');
});


