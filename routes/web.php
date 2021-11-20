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
Route::get('/adduser',[UserController::class, 'create']);
Route::post('/createuser', [UserController::class, 'addupdate']);
Route::get('/edituser/{id}',[UserController::class, 'edit']);
Route::post('/updateuser',[UserController::class, 'addupdate']);
Route::get('/delete/{id}',[UserController::class, 'delete']);

## TAX Routes ##

Route::get('/tax',[taxController::class,'view']);
Route::get('/addtax',[taxController::class, 'create']);
Route::post('/createtax',[taxController::class,'addupdate']);
Route::get('/edittax/{id}',[taxController::class, 'edit']);
Route::post('/updatetax',[taxController::class, 'addupdate']);
Route::get('/deletetax/{id}',[taxController::class, 'delete']);




## CATEGORY ROUTES ##

Route::get('/category',[categoryController::class,'view']);
Route::get('/category/add',[categoryController::class,'create']);
Route::post('/category/post',[categoryController::class,'addupdate']);
Route::get('/category/edit/{id}',[categoryController::class,'edit']);
// Route::post('/updatecategory',[categoryController::class,'addupdate']);
Route::get('/category/delete/{id}',[categoryController::class,'delete']);

 ## SUB CATEGORIES ROUTES ##

 
Route::get('/subCategory',[sub_categoryController::class,'view']);
Route::get('/addSubCategory',[sub_categoryController::class,'create']);
Route::post('/createsubCategory',[sub_categoryController::class,'addupdate']);
Route::get('/updatesubCategory/{id}',[sub_categoryController::class,'edit']);
Route::post('/createsubCategory',[sub_categoryController::class,'addupdate']);
Route::get('/deletesubCategory/{id}',[sub_categoryController::class,'delete']);



## PRODUCT ROUTES ##

Route::get('/products',[productController::class,'view']);
Route::get('/addproduct',[productController::class,'create']);
Route::post('/createproduct',[productController::class,'addupdate']);
Route::get('/updateproduct/{id}',[productController::class,'edit']);
Route::post('/updateproduct',[productController::class,'addupdate']);
Route::get('/deleteproduct/{id}',[productController::class,'delete']);


## VENDOR ROUTES ##
Route::get('/vendors', [vendorController::class,'view']);
Route::get('/addvendor', [vendorController::class,'create']);
Route::post('/createvendor',[vendorController::class,'addupdate']);
Route::get('/updatevendor/{id}', [vendorController::class,'edit']);
Route::post('/updatevendor',[vendorController::class,'addupdate']);
Route::get('/deletevendor/{id}', [vendorController::class,'delete']);

## ASSIGN PRODUCT ROUTES ##

Route::get('/assign',function(){
    return View('admin.assign_index');
});
Route::get('/assignproduct',[assignController::class,'create']);



require __DIR__.'/auth.php';