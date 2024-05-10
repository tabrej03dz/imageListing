<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FailedCustomerController;
use App\Http\Controllers\CategoryController;

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
Route::middleware(['visit'])->group(function(){
    Route::get('/{number?}', [HomeController::class, 'index'])->where('number', '[0-9]+');
});
    Route::post('imgSearch', [HomeController::class, 'imgSearch'])->name('imgSearch');
    Route::get('clearOldImage', [HomeController::class, 'clearOldImage'])->name('clearOldImage');

    Route::get('register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('userImageDownload/{image}', [HomeController::class, 'userImageDownload'])->name('userImageDownload');


Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::prefix('image')->name('image.')->group(function(){
            Route::get('/', [ImageController::class, 'index'])->name('index');
            Route::get('upload', [ImageController::class, 'uploadImage'])->name('upload');
            Route::post('store', [ImageController::class, 'store'])->name('store');
            Route::get('delete/{image}', [ImageController::class, 'destroy'])->name('destroy');
            Route::get('download/{image}', [ImageController::class, 'downloadImage'])->name('download');

            Route::post('search/{date}', [ImageController::class, 'imageShowByDate'])->name('search');
            Route::get('singleSend/{image}', [ImageController::class, 'singleImageSend'])->name('singleSend');

        });

        Route::prefix('images')->name('images.')->group(function(){
            Route::get('upload', [ImageController::class, 'uploadImage'])->name('upload');
            Route::get('delete/{date}', [ImageController::class, 'imageDeleteByDate'])->name('delete');
            Route::get('show/{date}', [ImageController::class, 'imageShowByDate'])->name('show');
            Route::get('send/{date}', [ImageController::class, 'sendImage'])->name('send');
        });

        Route::prefix('customer')->name('customer.')->group(function(){
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('create', [CustomerController::class, 'create'])->name('create');
            Route::get('edit/{customer}', [CustomerController::class, 'edit'])->name('edit');
            Route::get('destroy/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::post('store', [CustomerController::class, 'store'])->name('store');
            Route::post('update/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::get('images/{customer}', [CustomerController::class, 'customerImages'])->name('images');
            Route::get('status/{customer}', [CustomerController::class, 'status'])->name('status');

            Route::get('upload', [CustomerController::class, 'customerUpload'])->name('upload');
            Route::post('import', [CustomerController::class, 'customerImport'])->name('import');
            Route::get('search', [CustomerController::class, 'index'])->name('search');

            Route::prefix('failed')->name('failed.')->group(function(){
                Route::get('all', [FailedCustomerController::class, 'allFailedCustomer'])->name('all');
                Route::get('add/{phone}/{customer}', [FailedCustomerController::class, 'add'])->name('add');
                Route::get('remove/{customer}', [FailedCustomerController::class, 'remove'])->name('remove');
            });

            Route::get('category/delete/{category}/{customer}', [CategoryController::class, 'customerCategoryDelete'])->name('category.delete');
            Route::get('language/remove/{customer}/{index}', [CustomerController::class, 'customerLanguageRemove'])->name('language.remove');
        });

        Route::prefix('category')->name('category.')->group(function(){
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('update/{category}', [CategoryController::class, 'update'])->name('update');
            Route::get('destroy/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::get('profile', [HomeController::class, 'profile'])->name('profile');
        Route::post('setKeys', [HomeController::class, 'setKeys'])->name('setKeys');
    });



Route::get('/foo', function () {
    $exitCode = Artisan::call('storage:link');
    if ($exitCode === 0) {
        return 'Success';
    } else {
        return 'Failed'; // You can customize this message as needed
    }
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate:fresh', ['--seed' => true]);
    if ($exitCode === 0) {
        return 'Migration successful';
    } else {
        return 'Migration failed'; // You can customize this message as needed

    }
});


