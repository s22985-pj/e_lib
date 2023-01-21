<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\BookController;
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


Route::get('/', function () {
    return Inertia::render('Index');
})->name('login');

Route::post('/barcode-login', [AuthController::class, 'barcode']); // 
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {

    Route::get('/list', [BookController::class, 'index']);

    Route::get('/item/{book}', [BookController::class, 'show']);

    Route::get('/account', function () {
        return Inertia::render('Account');
    });

    Route::get('/add', [BookController::class, 'create']);
    Route::post('/create', [BookController::class, 'store']);
    Route::delete('/item/{book}', [BookController::class, 'destroy']);
    Route::post('/rent/{book}', [BookController::class, 'rent']);
    Route::post('/unrent/{book}', [BookController::class, 'unrent']);
});
