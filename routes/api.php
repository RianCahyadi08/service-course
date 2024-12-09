<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/mentors', [MentorController::class, 'store']);
Route::put('/mentors/{id}', [MentorController::class, 'update']);
Route::get('/mentors', [MentorController::class, 'index']);
Route::get('/mentors/{id}', [MentorController::class, 'show']);
Route::delete('/mentors/{id}', [MentorController::class, 'destroy']);

Route::post('/courses', [CourseController::class, 'store']);