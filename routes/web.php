<?php

use App\Http\Controllers\admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'admin',
        'name' => 'admin'
    ],
    function () {

        // Auth routes
        Route::middleware(['guest'])->group(function () {
            Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AuthController::class, 'login']);
            Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
            Route::post ('/register', [AuthController::class, 'register']);
        });

        Route::middleware(['auth'])->group(function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/start', [ProductController::class, 'start'])->name('start');
            Route::resource('products', ProductController::class);

        });
    }
);
