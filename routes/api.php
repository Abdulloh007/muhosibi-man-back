<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\CounterpartyController;
use App\Http\Controllers\CountrpartyCategoryController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\DocGroupController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\DocumentsTypeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PaymentAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\TransactionDocTypeController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiscalConfigController;

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
Route::get('activities', [ActivitiesController::class, 'index']);

Route::middleware('auth:api')->group( function () {

    Route::resource('devices', DevicesController::class);
    Route::resource('user', UserController::class);
    Route::get('me', [UserController::class, 'showMe']);
    Route::resource('organization', OrganizationController::class);
    Route::resource('cashbox', CashboxController::class);
    Route::resource('notification', NotificationsController::class);
    Route::get('user-notifications/{user}', [NotificationsController::class, 'show_by_user']);
    Route::get('docs4transac/{counterparty}', [DocumentsController::class, 'getDocs4Transaction']);
    Route::resource('payment-account', PaymentAccountController::class);
    Route::resource('counterparty', CounterpartyController::class);
    Route::resource('counterparty-category', CountrpartyCategoryController::class);
    Route::resource('doctypes', DocumentsTypeController::class);
    Route::resource('documents', DocumentsController::class);
    Route::get('documents/status/{status?}', [DocumentsController::class,'index']);
    Route::resource('transactions', TransactionsController::class);
    Route::get('transaction-types', [TransactionTypeController::class, 'index']);
    Route::get('transaction-doctypes', [TransactionDocTypeController::class, 'index']);
    // Route::resource('stuff', StuffController::class);
    Route::get('stuff/{organizationId}', [OrganizationController::class, 'getOrgStauff']);
    Route::post('stuff', [StuffController::class, 'store']);
    Route::get('stuff-one/{stuffId}', [StuffController::class, 'show']);
    Route::post('stuff-one/{id}', [StuffController::class, 'update']);
    Route::resource('activity', ActivitiesController::class);
    Route::resource('payments', PaymentController::class);
    Route::get('paymentsByOwner/{owner_id}', [PaymentController::class, 'getPaymentsByOwnerId']);
    Route::resource('invoices', InvoicesController::class);
    Route::resource('products', ProductsController::class);
    Route::get('docgroups', [DocGroupController::class, 'index']);
    Route::resource('currency', CurrencyController::class);


    // FiscalConfig
    Route::prefix('organizations/{organization}/fiscal-configs')->group(function () {
        Route::get('/', [FiscalConfigController::class, 'index']);
        Route::post('/', [FiscalConfigController::class, 'store']);
    });

    Route::prefix('fiscal-configs')->group(function () {
        Route::get('/{fiscalConfig}', [FiscalConfigController::class, 'show']);
        Route::patch('/{fiscalConfig}', [FiscalConfigController::class, 'update']);
        Route::delete('/{fiscalConfig}', [FiscalConfigController::class, 'destroy']);
    });


});

