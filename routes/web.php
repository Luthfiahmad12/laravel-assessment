<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return to_route('employees.index');
});

Route::resource('employees', EmployeeController::class);

Route::post('/upload', [EmployeeController::class, 'uploadTemp']);
Route::post('/delete', [EmployeeController::class, 'deleteTemp']);
