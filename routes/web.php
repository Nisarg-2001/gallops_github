<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\sub_categoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\assignController;

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

    ## DASHBOARD ROUTES ##
Route::get('/dashboard',[UserController::class,'dashboard'])->middleware(['auth'])->name('dashboard');




## USER ROUTES ##

Route::get('/user',[UserController::class,'view']);
Route::get('/user/add',[UserController::class, 'create']);
Route::post('/user/post', [UserController::class, 'addupdate']);
Route::get('/user/edit/{id}',[UserController::class, 'edit']);
Route::get('/user/delete/{id}',[UserController::class, 'delete']);

## TAX Routes ##

Route::get('/tax',[taxController::class,'view']);
Route::get('/tax/add',[taxController::class, 'create']);
Route::post('/tax/post',[taxController::class,'addupdate']);
Route::get('/tax/edit/{id}',[taxController::class, 'edit']);
Route::get('/tax/delete/{id}',[taxController::class, 'delete']);




## CATEGORY ROUTES ##

Route::get('/category',[categoryController::class,'view']);
Route::get('/category/add',[categoryController::class,'create']);
Route::post('/category/post',[categoryController::class,'addupdate']);
Route::get('/category/edit/{id}',[categoryController::class,'edit']);
Route::get('/category/delete/{id}',[categoryController::class,'delete']);

 ## SUB CATEGORIES ROUTES ##

 
Route::get('/subCategory',[sub_categoryController::class,'view']);
Route::get('/subCategory/add',[sub_categoryController::class,'create']);
Route::post('/subCategory/post',[sub_categoryController::class,'addupdate']);
Route::get('/subCategory/edit/{id}',[sub_categoryController::class,'edit']);
Route::get('/subCategory/delete/{id}',[sub_categoryController::class,'delete']);



## PRODUCT ROUTES ##

Route::get('/products',[productController::class,'view']);
Route::get('/product/add',[productController::class,'create']);
Route::post('/product/post',[productController::class,'addupdate']);
Route::get('/product/edit/{id}',[productController::class,'edit']);
Route::get('/product/delete/{id}',[productController::class,'delete']);


## VENDOR ROUTES ##
Route::get('/vendors', [vendorController::class,'view']);
Route::get('/vendor/add', [vendorController::class,'create']);
Route::post('/vendor/post',[vendorController::class,'addupdate']);
Route::get('/vendor/edit/{id}', [vendorController::class,'edit']);
Route::get('/vendor/delete/{id}', [vendorController::class,'delete']);

## ASSIGN PRODUCT ROUTES ##

// Route::get('/assign_product',function(){
//     return View('admin.assign_product.index');
// });

Route::get('/assign_product', [assignController::class,'view']);
Route::get('/assign_product/add',[assignController::class,'create']);
Route::get('/assign_product/edit/{id}', [assignController::class,'edit']);
Route::post('/assign_product/getTax',[assignController::class,'getTax']);
Route::post('/assign_product/post',[assignController::class,'addupdate']);





require __DIR__.'/auth.php';