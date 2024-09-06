<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiFizzBuzzController;

// Endpoint untuk FizzBuzz
Route::post('/fizzbuzz', [ApiFizzBuzzController::class, 'fizzBuzz']);
// Route::get('/fizzbuzz/{n}', [ApiFizzBuzzController::class, 'fizzBuzz']);

// Endpoint untuk findMaxForm
Route::post('/findMaxForm', [ApiFizzBuzzController::class, 'findMaxForm']);

// http://localhost:8000/api/findMaxForm?strs[]=10&strs[]=0001&strs[]=111001&strs[]=1&strs[]=0&m=5&n=3


Route::post('/min-largest-sum', [ApiFizzBuzzController::class, 'minLargestSum']);
