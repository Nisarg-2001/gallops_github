<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\vendorController;




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

## USER ROUTES ##

Route::get('/user',[UserController::class,'view']);
Route::get('/adduser', function () {
    return view('admin.add_user');
})->name('add');
Route::post('/createuser', [UserController::class, 'addupdate']);
Route::get('/edituser/{id}',[UserController::class, 'edit']);
Route::post('/updateuser',[UserController::class, 'addupdate']);
Route::get('/delete/{id}',[UserController::class, 'delete']);

## TAX Routes ##

Route::get('/tax',[taxController::class,'view']);
Route::get('/addtax', function () {
    return view('admin.add_tax');
});
Route::post('/createtax',[taxController::class,'addupdate']);
Route::get('/edittax/{id}',[taxController::class, 'edit']);
Route::post('/updatetax',[taxController::class, 'addupdate']);
Route::get('/deletetax/{id}',[taxController::class, 'delete']);




## CATEGORY ROUTES ##

Route::get('/category',[categoryController::class,'view']);
Route::get('/addcategory', function () {
    return view('admin.add_Category');
});
Route::post('/createcategory',[categoryController::class,'addupdate']);
Route::get('/updatecategory/{id}',[categoryController::class,'edit']);
Route::post('/updatecategory',[categoryController::class,'addupdate']);
Route::get('/deletecategory/{id}',[categoryController::class,'delete']);




## PRODUCT ROUTES ##

Route::get('/products',[productController::class,'view']);
Route::get('/addproduct',[productController::class,'create']);
Route::post('/createproduct',[productController::class,'addupdate']);
Route::get('/updateproduct/{id}',[productController::class,'edit']);
Route::post('/updateproduct',[productController::class,'addupdate']);
Route::get('/deleteproduct/{id}',[productController::class,'delete']);


## VENDOR ROUTES ##
Route::get('/vendors', [vendorController::class,'view']);
Route::get('/addvendor',function(){
    return view('admin.add_vendor');
});
Route::post('/createvendor',[vendorController::class,'addupdate']);
Route::get('/updatevendor/{id}', [vendorController::class,'edit']);
Route::post('/updatevendor',[vendorController::class,'addupdate']);
Route::get('/deletevendor/{id}', [vendorController::class,'delete']);

Route::get('/placeorder', function () {
    return view('user.forms.place_order');
})->name('order');

require __DIR__.'/auth.php';
