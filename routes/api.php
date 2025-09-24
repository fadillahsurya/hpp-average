<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;


Route::apiResource('transactions', TransactionController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->where(['transaction' => '[0-9]+']);
