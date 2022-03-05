<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoriesController;

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

Route::get('/',[HomeController::class,'index'])->name('home');


// //Route::get('/welcome.php' , ['App\Http\Controllers\WelcomeController','welcome']); // Sending callback function --OR--
// Route::get('/welcome.php' , [WelcomeController::class,'welcome']); //  Better way for Sending callback function

// Route::get('/welcome/to/laravel' , 'App\Http\Controllers\WelcomeController@welcome');

// Route::get('products' , [ProductsController::class,'index']);
// Route::get('products/{name}' , [ProductsController::class,'show']);// can be {name?} => to make it optional to send a name or not

// this route instead of the 7 routes 
Route::get('admin/categories/trash',[CategoriesController::class, 'trash'])->name('categories.trash');
Route::put('admin/categories/trash/{id?}',[CategoriesController::class, 'restore'])->name('categories.restore');
Route::delete('admin/categories/trash/{id?}',[CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

Route::get('admin/products/trash',[ProductsController::class, 'trash'])->name('products.trash');
Route::put('admin/products/trash/{id?}',[ProductsController::class, 'restoreProduct'])->name('products.restore');
Route::delete('admin/products/trash/{id?}',[ProductsController::class, 'forceDelete'])->name('products.force-delete');


Route::resource('/admin/categories',CategoriesController::class);
Route::resource('/admin/products',ProductsController::class)->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
