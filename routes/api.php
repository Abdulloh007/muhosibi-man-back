<?php

use App\Http\Controllers\DevicesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDgyYmU2M2Q1MThiZjlmY2Q2ZjZhMzNiZTNkM2U3YWE0YjcwNDBlZDM4M2JkOTljNmZkM2Q2MmRiNGFjZWY5YmMxMjJhZGI0Nzc1OTZmOTQiLCJpYXQiOjE3MDYyMDM3NDcuOTY2MDgzLCJuYmYiOjE3MDYyMDM3NDcuOTY2MDk2LCJleHAiOjE3Mzc4MjYxNDcuNDkzNDQ1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.LrKfPNbAG46qMuQGvi1EIHiTDodl1mfTzc5uYr2wL05jP10pCldLfcBBJdPTsoZQ4qWHWPw33POVHlWU9aZ2NfXifCCxo1atXS5bntAiKtm8M5kH3pztVis0qFwuooj7UuWdf-EyRh8LGyBVgIxa_Vr4s0hM4usnzJMwFoOyTSORTOEx8103tqIPIJbD1iliIBdwLhwqpugzEVhuSXX2KrJ7WIHg3KMFia_gyYlAH7fI7Q7_Gd458gDxTIx03-q_5lJeexz8g4tXEYcVREHPlYKnnDBk_IhzmSD26fqgbGqE5dxyNxADH5FvOtyjWLbSuWPZN0IE7KG95h6kxB7Nj5gUUHgVD-srpKGo4spBRiepPFYKNFxroK7dTa1taFqTxgAD1jPG8XkP76qgcNyrqvH0h2WK9EizAJfxqFFqydnKov69v6mHZkmF9tn6PRnekkwiZXmTISCwnGtM-RUVFFH9r67giqGQv5BL6IYJM1a3hoQC9d0hVVj080ptbig9JS4WEJ3dbsHXLRVjjV0xtc7SJ0tJGQGCLABX_Tchm4jEQgAcNS66Dg2sfSBISNfUtPzkGEgqCTRmHqnvtiEdpKmYMLsQNj29zZ1gZ5aARHIXuskQe3dFT8EXu4WfmEVfdT4xYAIWG2OO8his3c8eHDQLmGVqvoWI0-mGDXJiq4k


Route::post('register', [UserController::class, 'store']);
Route::post('auth', [UserController::class, 'auth']);
Route::resource('organization', OrganizationController::class);


Route::middleware('auth:api')->group( function () {

    Route::resource('user', UserController::class);
    Route::resource('devices', DevicesController::class);
});
