<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin');
Route::get('/product', function () {
    return view('admin.product_masters');
})->name('admin');
Route::get('/orders', function () {
    return view('user.order_masters');
})->name('user');
Route::get('/user', function () {
    return view('admin.user_index');
})->name('user');
Route::get('/tax', function () {
    return view('admin.tax_index');
})->name('user');
Route::get('/category', function () {
    return view('admin.category_index');
})->name('user');
Route::get('/addcategory', function () {
    return view('admin.add_Category');
})->name('user');
Route::get('/adduser', function () {
    return view('admin.add_user');
})->name('user');
Route::get('/products', function () {
    return view('admin.product_index');
})->name('user');
Route::get('/addproduct', function () {
    return view('admin.add_product');
})->name('user');
Route::get('/vendors', function () {
    return view('admin.vendor_index');
})->name('user');
Route::get('/addvendor', function () {
    return view('admin.add_vendor');
})->name('user');
Route::get('/addtax', function () {
    return view('admin.add_tax');
})->name('user');
Route::get('/placeorder', function () {
    return view('user.forms.place_order');
})->name('order');

require __DIR__.'/auth.php';
