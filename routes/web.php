<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiIntegrationController;
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
    return redirect(route('login'));
});


Route::GET('/login', [ApiIntegrationController::class, 'login'])->name('login');
Route::POST('/api-authentication', [ApiIntegrationController::class, 'index'])->name('api.login');
Route::GET('/authors', [ApiIntegrationController::class, 'authors'])->name('api.authors');
Route::GET('/author-delete/{id?}', [ApiIntegrationController::class, 'author_delete'])->name('api.delete.author');
Route::GET('/author-single/{id?}', [ApiIntegrationController::class, 'single'])->name('api.single.author');
Route::GET('/book-delete/{id?}', [ApiIntegrationController::class, 'book_delete'])->name('api.book.delete');
Route::GET('/logout', [ApiIntegrationController::class, 'logout'])->name('logout');
Route::GET('/profile', [ApiIntegrationController::class, 'profile'])->name('profile');
Route::GET('/add-book', [ApiIntegrationController::class, 'add_book'])->name('add.book');
Route::POST('/store-book', [ApiIntegrationController::class, 'store_book'])->name('store.book');
