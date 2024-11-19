<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users','users')->name('users123');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('restricted', function(){
    return "Anda berusia lebih dari 18 tahun!";
}) ->middleware('checkage');

Route::get('restricted', function(){
    return "Anda adalah Admin!";
}) ->middleware('admin');

Route::controller(UserController::class)->group(function() {
    Route::get('/users','users')->name('users123');
});

Route::resource('users', UserController::class);

Route::resource('edit', UserController::class);

Route::resource('gallery', GalleryController::class);
Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');