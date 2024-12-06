<?php

use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', fn() => to_route('api.employees'));

Route::get('employees', [EmployeeController::class, 'index'])->name('api.employees');
Route::get('employees/{id}', [EmployeeController::class, 'show']);
