<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharactersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PasswordController;

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

Route::get('/', [CharactersController::class, 'home'])->name('/');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('characters', CharactersController::class);
    Route::resource('users', UsersController::class);
    Route::get('password/{id}/edit', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('password/update/{id}', [PasswordController::class, 'update'])->name('password.update');
});
