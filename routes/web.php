<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/ui'));
Route::get('/ui', fn () => view('home'))->name('ui');
