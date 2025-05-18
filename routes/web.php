<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'Main');
Route::view('/', 'Pages.Dashboard')->name('sensors');
Route::view('/Maps', 'Pages.Maps')->name('maps');
