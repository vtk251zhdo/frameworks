<?php

use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

Route::get('/labels', [LabelController::class, 'index']);
Route::get('/labels/{id}', [LabelController::class, 'show']);
Route::post('/labels', [LabelController::class, 'store']);
Route::patch('/labels/{id}', [LabelController::class, 'update']);
Route::delete('/labels/{id}', [LabelController::class, 'destroy']);
