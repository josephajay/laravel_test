<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login_submit');


Route::middleware(['checkAccessToken'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/authors', [AuthController::class, 'getAuthors'])->name('authors');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/author/delete/{id}', [AuthController::class, 'deleteAuthor'])->name('author_delete');
    Route::get('/author/delete_book/{id}/{auther_id}', [AuthController::class, 'deleteBook'])->name('delete_book');
    Route::get('/author/view/{id}', [AuthController::class, 'authorDetails'])->name('author_view');
    Route::get('/add_book', [AuthController::class, 'addBook'])->name('add_book');
    Route::post('/add_new_book', [AuthController::class, 'addNewBook'])->name('add_new_book');

});

