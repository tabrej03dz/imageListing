<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FailedCustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadTrackController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\RecycleController;

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

Route::get('welcome', function(){
    return view('welcome1');
});

Route::post('getState/{id}', [\App\Http\Controllers\AddressController::class, 'getState']);
Route::post('getCity', [\App\Http\Controllers\AddressController::class, 'getCity']);

Route::get('packageAssignToAllCustomer', [DashboardController::class, 'packageAssignToAllCustomer'])->name('packageAssignToAllCustomer');
Route::middleware(['visit'])->group(function(){
    Route::get('/{number?}', [HomeController::class, 'index'])->where('number', '[0-9]+');
});
    Route::post('imgSearch', [DashboardController::class, 'imgSearch'])->name('imgSearch');
    Route::get('clearOldImage', [DashboardController::class, 'clearOldImage'])->name('clearOldImage');

    Route::get('register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('userImageDownload/{image}', [DashboardController::class, 'userImageDownload'])->name('userImageDownload');


Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::prefix('image')->name('image.')->group(function(){
            Route::get('/', [ImageController::class, 'index'])->name('index');
            Route::get('upload', [ImageController::class, 'uploadImage'])->name('upload');
            Route::post('store', [ImageController::class, 'store'])->name('store');
            Route::get('delete/{image}', [ImageController::class, 'destroy'])->name('destroy');
            Route::get('download/{image}', [ImageController::class, 'downloadImage'])->name('download');
            Route::post('search/{date}', [ImageController::class, 'imageShowByDate'])->name('search');
            Route::get('singleSend/{image}', [ImageController::class, 'singleImageSend'])->name('singleSend');

            Route::get('show_all', [ImageController::class, 'showAllImages'])->name('show_all');
        });


        Route::prefix('images')->name('images.')->group(function(){
            Route::get('upload', [ImageController::class, 'uploadImage'])->name('upload');
            Route::get('delete/{date}', [ImageController::class, 'imageDeleteByDate'])->name('delete');
            Route::get('show/{date}', [ImageController::class, 'imageShowByDate'])->name('show');
            Route::get('send/{date}', [ImageController::class, 'sendImage'])->name('send');
            Route::get('sendImage/{date}', [ImageController::class, 'sendImageWithAjax'])->name('sendImage');
            Route::get('sentCount/{date}', [ImageController::class, 'sentCount'])->name('sentCount');
        });

        Route::prefix('package')->name('package.')->group(function(){
            Route::get('/', [PackageController::class, 'index'])->name('index');
            Route::get('create', [PackageController::class, 'create'])->name('create');
            Route::post('store', [PackageController::class, 'store'])->name('store');
            Route::get('edit/{package}', [PackageController::class, 'edit'])->name('edit');
            Route::post('update/{package}', [PackageController::class, 'update'])->name('update');
            Route::get('destroy/{package}', [PackageController::class, 'destroy'])->name('destroy');

            Route::get('assignToCustomer/{package}', [PackageController::class, 'packageAssignToCustomerForm'])->name('assignToCustomer');
            Route::post('assignToCustomer/{package}', [PackageController::class, 'packageAssignToCustomer'])->name('assignToCustomer');

            Route::get('ofCustomer/delete/{customerPackage}', [PackageController::class, 'customerPackageDelete'])->name('ofCustomer.delete');
            Route::get('ofCustomer/edit/{customerPackage}', [PackageController::class, 'customerPackageEdit'])->name('ofCustomer.edit');
            Route::post('ofCustomer/update/{customerPackage}', [PackageController::class, 'customerPackageUpdate'])->name('ofCustomer.update');
            Route::get('ofCustomer/status/{customerPackage}', [PackageController::class, 'customerPackageStatus'])->name('ofCustomer.status');
            Route::get('renew/{package}', [PackageController::class, 'renewPackage'])->name('renew');

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

            Route::get('details/{customer}', [CustomerController::class, 'customerDetails'])->name('details');

            Route::prefix('failed')->name('failed.')->group(function(){
                Route::get('all', [FailedCustomerController::class, 'allFailedCustomer'])->name('all');
                Route::get('add/{customer}', [FailedCustomerController::class, 'add'])->name('add');
                Route::get('remove/{customer}', [FailedCustomerController::class, 'remove'])->name('remove');
                Route::get('removeAll', [FailedCustomerController::class, 'removeAll'])->name('removeAll');
            });

            Route::get('assignToPackage/{customer}', [PackageController::class, 'customerAssignToPackageForm'])->name('assignToPackage');
            Route::Post('assignToPackage/{customer}', [PackageController::class, 'customerAssignToPackage'])->name('assignToPackage');

            Route::get('category/delete/{category}/{customer}', [CategoryController::class, 'customerCategoryDelete'])->name('category.delete');
            Route::get('language/delete/{language}/{customer}', [LanguageController::class, 'customerLanguageDelete'])->name('language.delete');

            Route::get('export', [CustomerController::class, 'customerExport'])->name('export');

            Route::post('frame/update/{customer}', [CustomerController::class, 'updateFrame'])->name('frame.update');
        });

        Route::prefix('user')->name('user.')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('update/{user}', [UserController::class, 'update'])->name('update');
            Route::get('delete/{user}', [UserController::class, 'delete'])->name('delete');
        });

        Route::prefix('language')->name('language.')->group(function(){
            Route::get('/', [Languagecontroller::class, 'index'])->name('index');
            Route::get('create', [LanguageController::class, 'create'])->name('create');
            Route::post('store', [LanguageController::class, 'store'])->name('store');
            Route::get('destroy/{language}', [LanguageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('category')->name('category.')->group(function(){
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('update/{category}', [CategoryController::class, 'update'])->name('update');
            Route::get('destroy/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('setKeys', [DashboardController::class, 'setKeys'])->name('setKeys');

        Route::prefix('downloads')->name('downloads.')->group(function(){
            Route::get('view', [DownloadTrackController::class, 'view'])->name('view');
        });

        Route::prefix('payment')->name('payment.')->group(function(){
            Route::get('add/{customerPackage}', [PaymentController::class, 'paymentAdd'])->name('add');
            Route::post('make/{customerPackage}', [PaymentCOntroller::class, 'makePayment'])->name('make');
        });

        Route::prefix('note')->name('note.')->group(function(){
            Route::get('/', [NoteController::class, 'index'])->name('index');
            Route::get('create/{user}', [NoteController::class, 'create'])->name('create');
            Route::post('store/{user}', [NoteController::class, 'store'])->name('store');
            Route::get('edit/{note}', [NoteController::class, 'edit'])->name('edit');
            Route::post('update/{note}', [NoteController::class, 'update'])->name('update');
            Route::get('delete/{note}', [NoteController::class, 'delete'])->name('delete');
        });

        Route::prefix('information')->name('information.')->group(function(){
           Route::get('/', [InformationController::class, 'index'])->name('index');
           Route::get('create', [InformationController::class, 'create'])->name('create');
           Route::post('store', [InformationController::class, 'store'])->name('store');
           Route::get('edit/{information}', [InformationController::class, 'edit'])->name('edit');
           Route::post('update/{information}', [InformationController::class, 'update'])->name('update');
           Route::get('delete/{information}', [InformationController::class, 'delete'])->name('delete');
           Route::post('send', [InformationController::class, 'informationSendToUser'])->name('send');
        });

        Route::prefix('recycle')->name('recycle.')->group(function(){
            Route::get('/', [RecycleController::class, 'index'])->name('index');
//            Route::get('customerRestore/{id}', [RecycleController::class, 'customerRestore'])->name('customerRestore');
//            Route::get('customerDestroy/{id}', [RecycleController::class, 'customerDestroy'])->name('customerDestroy');
//            Route::get('categoryRestore/{id}', [RecycleController::class, 'categoryRestore'])->name('categoryRestore');
//            Route::get('categoryDelete/{id}', [RecycleController::class, 'categoryDelete'])->name('categoryDelete');
//            Route::get('languageRestore/{id}', [RecycleController::class, 'languageRestore'])->name('languageRestore');
//            Route::get('languageDelete/{id}', [RecycleController::class, 'languageDelete'])->name('languageDelete');
//            Route::get('packageDelete/{id}', [RecycleController::class, 'packageDelete'])->name('packageDelete');
//            Route::get('packageRestore/{id}', [RecycleController::class, 'packageRestore'])->name('packageRestore');
//            Route::get('noteDelete/{id}', [RecycleController::class, 'noteDelete'])->name('noteDelete');
//            Route::get('noteRestore/{id}', [RecycleController::class, 'noteRestore'])->name('noteRestore');
//            Route::get('deleteAllCustomer', [RecycleController::class, 'clearAllCustomer'])->name('deleteAllCustomer');
//            Route::get('restoreAllCustomer', [RecycleController::class, 'restoreAllCustomer'])->name('restoreAllCustomer');
//            Route::get('deleteAllCategories', [RecycleController::class, 'clearAllCategories'])->name('deleteAllCategories');
//            Route::get('restoreAllCategories', [RecycleController::class, 'restoreAllCategories'])->name('restoreAllCategories');
//            Route::get('restoreAllLanguages', [RecycleController::class, 'restoreAllLanguages'])->name('restoreAllLanguages');
//            Route::get('deleteAllLanguages', [RecycleController::class, 'deleteAllLanguages'])->name('deleteAllLanguages');
//            Route::get('restoreAllPackages', [RecycleController::class, 'restoreAllPackages'])->name('restoreAllPackages');
//            Route::get('deleteAllPackages', [RecycleController::class, 'deleteAllPackages'])->name('deleteAllPackages');
//            Route::get('imageDelete/{id}', [RecycleController::class, 'imageDelete'])->name('imageDelete');
//            Route::get('imageRestore/{id}', [RecycleController::class, 'imageRestore'])->name('imageRestore');
//            Route::get('deleteAllImages', [RecycleController::class, 'deleteAllImages'])->name('deleteAllImages');
//            Route::get('restoreAllImages', [RecycleController::class, 'restoreAllImages'])->name('restoreAllImages');

            Route::prefix('restore')->name('restore.')->group(function (){
                Route::get('customer/{id}', [RecycleController::class, 'customerRestore'])->name('customer');
                Route::get('category/{id}', [RecycleController::class, 'categoryRestore'])->name('category');
                Route::get('language/{id}', [RecycleController::class, 'languageRestore'])->name('language');
                Route::get('package/{id}', [RecycleController::class, 'packageRestore'])->name('package');
                Route::get('note/{id}', [RecycleController::class, 'noteRestore'])->name('note');
                Route::get('image/{id}', [RecycleController::class, 'imageRestore'])->name('image');
                Route::get('allCustomer', [RecycleController::class, 'restoreAllCustomer'])->name('allCustomer');
                Route::get('allCategories', [RecycleController::class, 'restoreAllCategories'])->name('allCategories');
                Route::get('allLanguages', [RecycleController::class, 'restoreAllLanguages'])->name('allLanguages');
                Route::get('allPackages', [RecycleController::class, 'restoreAllPackages'])->name('allPackages');
                Route::get('allImages', [RecycleController::class, 'restoreAllImages'])->name('allImages');
            });

            Route::prefix('destroy')->name('destroy.')->group(function (){
                Route::get('customer/{id}', [RecycleController::class, 'customerDestroy'])->name('customer');
                Route::get('category/{id}', [RecycleController::class, 'categoryDelete'])->name('category');
                Route::get('language/{id}', [RecycleController::class, 'languageDelete'])->name('language');
                Route::get('package/{id}', [RecycleController::class, 'packageDelete'])->name('package');
                Route::get('note/{id}', [RecycleController::class, 'noteDelete'])->name('note');
                Route::get('image/{id}', [RecycleController::class, 'imageDelete'])->name('image');
                Route::get('allCustomer', [RecycleController::class, 'clearAllCustomer'])->name('allCustomer');
                Route::get('allCategories', [RecycleController::class, 'clearAllCategories'])->name('allCategories');
                Route::get('allLanguages', [RecycleController::class, 'deleteAllLanguages'])->name('allLanguages');
                Route::get('allPackages', [RecycleController::class, 'deleteAllPackages'])->name('allPackages');
                Route::get('allImages', [RecycleController::class, 'deleteAllImages'])->name('allImages');
            });
        });



        Route::get('visits', [DownloadTrackController::class, 'visits'])->name('visits');
        Route::get('clearVisits', [DownloadTrackController::class, 'clearVisits'])->name('clearVisits');
        Route::get('clearDownloads', [DownloadTrackController::class, 'clearDownloads'])->name('clearDownloads');

        Route::get('enableMultipleSend', [ImageController::class, 'enableMultipleSend'])->name('enableMultipleSend');
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

Route::get('/onlyMigrate', function () {
    $exitCode = Artisan::call('migrate');
    if ($exitCode === 0) {
        return 'Migration successful';
    } else {
        return 'Migration failed'; // You can customize this message as needed

    }
});




