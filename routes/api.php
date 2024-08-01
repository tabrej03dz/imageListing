<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('imageSearch', [HomeController::class, 'imageSearch'])->name('imageSearch');
Route::get('imageDownload/{imageId}', [HomeController::class, 'imageDownload'])->name('imageDownload');

Route::post('addCustomer', [HomeController::class, 'addCustomer'])->name('addCustomer');

