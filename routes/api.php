<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacationPlanController;

Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('register', [AuthController::class,'register'])->name('register');

Route::resource('/vacationplans', VacationPlanController::class)->middleware('auth:api');
Route::get('/vacationplans/{vacation_plan}/pdf', [VacationPlanController::class, 'pdf'])->name('pdf')->middleware('auth:api');
Route::get('/vacationplans/{vacation_plan}/pdf/noauth', [VacationPlanController::class, 'pdf'])->name('pdf');