<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{number?}', [HomeController::class, 'index'])->where('number', '[0-9]+');
Route::get('clearOldImage', [HomeController::class, 'clearOldImage'])->name('clearOldImage');

Route::get('register', [AuthController::class, 'registerForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('dashboard', function (){
        return view('backend.dashboard');
    })->name('dashboard');
    Route::prefix('image')->name('image.')->group(function(){
        Route::get('/', [ImageController::class, 'index'])->name('index');
        Route::get('upload', [ImageController::class, 'uploadImage'])->name('upload');
        Route::post('upload', [ImageController::class, 'store'])->name('upload');
        Route::get('delete/{image}', [ImageController::class, 'destroy'])->name('destroy');
        Route::get('download/{image}', [ImageController::class, 'downloadImage'])->name('download');

        Route::post('search', [ImageController::class, 'index'])->name('search');
    });

});


