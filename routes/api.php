<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RiskController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::get('/company', [CompanyController::class, 'index']);
Route::get('/company/{id}', [CompanyController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::get('/risks', [RiskController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function () {
        return response()->json(['data' => Auth::guard('api')->user()]);
    });
    Route::get('/organizations', [OrganizationController::class, 'getOrganizationTree'])->middleware('can.input.hiyari.from.pc');
    Route::post('/images/upload', [ImageUploadController::class, 'upload']);
    Route::get('/images/{fileName}', [ImageUploadController::class, 'getImage']);
});




Route::post('/risk/store', [RiskController::class, 'store']);
