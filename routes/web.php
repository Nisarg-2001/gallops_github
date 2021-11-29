<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\sub_categoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\assignController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\inwardController;
use App\Http\Controllers\outwardController;
<<<<<<< HEAD
use App\Http\Controllers\userOrderController;


=======
use App\Http\Controllers\adminOrderController;
use App\Http\Controllers\purchaseOrderController;
>>>>>>> 5b0b84d957d96fdf65793ba73beb154a6fbeba76


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

Route::group(['middleware' => 'auth'], function() {

## DASHBOARD ROUTES ##
Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard');




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
Route::get('/assign_product', [assignController::class,'view']);
Route::get('/assign_product/add',[assignController::class,'create']);
Route::get('/assign_product/edit/{id}', [assignController::class,'edit']);
Route::post('/assign_product/getTax',[assignController::class,'getTax']);
Route::post('/assign_product/post',[assignController::class,'addupdate']);

##  ORDER ROUTES ##
Route::get('/order',[orderController::class,'view']);
Route::get('/order/add',[orderController::class,'create']);
Route::get('/order/{id}', [orderController::class,'edit']);
Route::post('/order/post',[orderController::class,'addupdate']);
Route::post('/order/getProduct',[orderController::class,'getProduct']);
Route::post('/order/getTaxes',[orderController::class,'getTaxes']);
Route::get('/order/delete/{id}',[orderController::class,'delete']);
Route::get('/order/invoice',[orderController::class,'invoice']);

##  ADMIN ORDER ROUTES ##
Route::get('/admin-order',[adminOrderController::class,'view']);
Route::get('/place-purchase-order/{id}', [adminOrderController::class,'getOrderDetails']);
Route::post('/admin-order/updateStatus',[adminOrderController::class,'updateStatus']);
Route::post('/admin-order/place-purhcase-order',[adminOrderController::class,'placePurchaseOrder']);

## VENDOR ORDER ROUTES ##
Route::get('/purchase-order',[purchaseOrderController::class,'view']);

Route::post('/admin-order/getVendorsByProduct', [adminOrderController::class,'getVendorsByProduct']);
Route::get('/admin-order/{id}', [adminOrderController::class,'edit']); //display same view from order controller


##  INWARD ROUTES ##
Route::get('/inward',[inwardController::class,'view']);
Route::get('/inward/add',[inwardController::class,'create']);

##  OUTWARD ROUTES ##
Route::get('/outward',[outwardController::class,'view']);
Route::get('/outward/add',[outwardController::class,'create']);

## RETURN GOODS ## 
Route::get('/return',function(){
    return view('admin.return_goods.index');
});

});


##  FRANCHISE ROUTES    ##
Route::get('/user/dashboard/',function(){
    return view('user.dashboard');
});
Route::get('/user/order/',[userOrderController::class,'view']);

## VENDOR SCREEN ROUTES ##
Route::get('vendor/dashboard',function(){
    return view('vendors.dashboard');
});





require __DIR__.'/auth.php';