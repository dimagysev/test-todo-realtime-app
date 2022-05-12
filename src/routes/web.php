<?php

use Illuminate\Support\Facades\Route;


Route::get('/', fn() => view('welcome'));
Route::fallback(fn() => view('welcome'));
