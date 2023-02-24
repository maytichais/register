<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Authenticate;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\AssetController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['guest']], function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/edit_profile', [ProfileController::class, 'editProfileForm'])->name('edit_profile');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/get_profile', [ProfileController::class, 'getProfile']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/api/update_profile', [ProfileController::class, 'updateProfile']);
    Route::post('/api/upload_image',  [AssetController::class, 'storeImage'])->name('image.store');
});

