<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomController;


Route::get('/classrooms', [ClassroomController::class,'index']);

Route::get('/classrooms/{id}', [ClassroomController::class,'show']);

Route::post('/classrooms', [ClassroomController::class,'store']);

Route::patch('/classrooms/{id}', [ClassroomController::class,'update']);

Route::delete('/classrooms/{id}', [ClassroomController::class,'destroy']);
