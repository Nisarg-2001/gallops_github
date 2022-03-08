<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\sub_categoryController;
use App\Http\Controllers\unitController;
use App\Http\Controllers\productController;
use App\Http\Controllers\shelflifeController;
use App\Http\Controllers\vendorController;
use App\Http\Controllers\assignController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\inwardController;
use App\Http\Controllers\outwardController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userOrderController;
use App\Http\Controllers\adminOrderController;
use App\Http\Controllers\purchaseOrderController;
use App\Http\Controllers\returnController;
use App\Http\Controllers\invoiceController;






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


Route::group(['middleware' => 'admin'], function(){


## DASHBOARD ROUTES ##
Route::get('/dashboard',[userController::class,'dashboard'])->name('dashboard');




## USER ROUTES ##
Route::get('/user',[userController::class,'view']);
Route::get('/user/add',[userController::class, 'create']);
Route::post('/user/post', [userController::class, 'addupdate']);
Route::get('/user/edit/{id}',[userController::class, 'edit']);
Route::get('/user/delete/{id}',[userController::class, 'delete']);

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

## DEPARTMENT ROUTES ##
Route::get('/department',[departmentController::class,'view']);
Route::get('/department/add',[departmentController::class,'create']);
Route::post('/department/post',[departmentController::class,'addupdate']);
Route::get('/department/edit/{id}',[departmentController::class,'edit']);
Route::get('/department/delete/{id}',[departmentController::class,'delete']);

## SUB CATEGORIES ROUTES ##
Route::get('/subCategory',[sub_categoryController::class,'view']);
Route::get('/subCategory/add',[sub_categoryController::class,'create']);
Route::post('/subCategory/post',[sub_categoryController::class,'addupdate']);
Route::get('/subCategory/edit/{id}',[sub_categoryController::class,'edit']);
Route::get('/subCategory/delete/{id}',[sub_categoryController::class,'delete']);

## UNIT OF MEASUREMENT ROUTES ##
Route::get('/unit',[unitController::class,'view']);
Route::get('/unit/add',[unitController::class,'create']);
Route::post('/unit/post',[unitController::class,'addupdate']);
Route::get('/unit/edit/{id}',[unitController::class,'edit']);
Route::get('/unit/delete/{id}',[unitController::class,'delete']);

## PRODUCT ROUTES ##
Route::get('/products',[productController::class,'view']);
Route::get('/product/add',[productController::class,'create']);
Route::post('/product/post',[productController::class,'addupdate']);
Route::get('/product/edit/{id}',[productController::class,'edit']);
Route::get('/product/delete/{id}',[productController::class,'delete']);


## PRODUCT SHELF LIFE ROUTES ##
Route::get('/productshelflife',[shelflifeController::class,'view']);
Route::get('/productshelflife/add',[shelflifeController::class,'create']);
Route::post('/productshelflife/post',[shelflifeController::class,'addupdate']);
Route::get('/productshelflife/edit/{id}',[shelflifeController::class,'edit']);
Route::get('/productshelflife/delete/{id}',[shelflifeController::class,'delete']);

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
Route::get('/assign_product/delete/{id}',[assignController::class,'delete']);

##  ORDER ROUTES ##

##  ADMIN ORDER ROUTES ##
Route::get('/admin-order',[adminOrderController::class,'view']);
Route::get('/place-purchase-order/{id}', [adminOrderController::class,'getOrderDetails']);
Route::post('/admin-order/updateOrder',[adminOrderController::class,'updateOrder']);
Route::post('/admin-order/place-purhcase-order',[adminOrderController::class,'placePurchaseOrder']);
Route::get('/admin-order/{id}', [adminOrderController::class,'edit']); //display same view from order controller
Route::post('/admin-order/getVendorsByProduct', [adminOrderController::class,'getVendorsByProduct']);

## VENDOR ORDER ROUTES ##
Route::get('/vendor-order',[purchaseOrderController::class,'view']);
Route::get('/vendor-order/{id}',[purchaseOrderController::class,'edit']);
Route::get('/purchase-order',[purchaseOrderController::class,'view']);
Route::post('/vendor-order/post', [purchaseOrderController::class,'updatePurchaseOrder']);






## REPORTS ROUTES   ##
Route::get('/report/raw-stock',[productController::class,'report']);
Route::post('/report/raw-stock',[productController::class,'report']);
Route::get('/report/order',[orderController::class,'report']);
Route::post('/report/order',[orderController::class,'report']);
Route::get('/report/purchase-order',[purchaseOrderController::class,'report']);
Route::post('/report/purchase-order',[purchaseOrderController::class,'report']);
Route::get('/report/inward',[inwardController::class,'report']);
Route::post('/report/inward',[inwardController::class,'report']);
Route::get('/report/outward',[outwardController::class,'report']);
Route::post('/report/outward',[outwardController::class,'report']);
Route::get('/report/opening-stock',[departmentController::class,'opening_stock']);
Route::post('/report/opening-stock',[departmentController::class,'opening_stock']);
Route::get('/report/closing-stock',[departmentController::class,'closing_stock']);
Route::get('/report/stock-ledger',[departmentController::class,'stock_ledger']);
Route::post('/report/stock-ledger',[departmentController::class,'stock_ledger']);
Route::post('/report/closing-stock',[departmentController::class,'closing_stock']);
Route::get('/report/return',[returnController::class,'report']);
Route::post('/report/return',[returnController::class,'report']);
Route::get('/report/item-master',[productController::class,'item_master']);
Route::get('/expiry',[productController::class,'expiry']);



## RETURN GOODS ## 
Route::get('/return',[returnController::class,'view']);
Route::get('/return/add',[returnController::class,'create']);
Route::get('/return/edit/{id}', [returnController::class,'edit']);
Route::get('/return/view/{id}', [returnController::class,'viewOutward']);
Route::post('/return/post',[returnController::class,'addupdate']);
Route::get('/return/print/{id}',[returnController::class,'invoice']);
Route::get('/return/delete/{id}',[orderController::class,'delete']);
Route::get('/vendor-order',[purchaseOrderController::class,'view']);




Route::post('/resetpassword',[userController::class,'resetPassword']);

});


## ROLES ROUTES ##
Route::get('/role',[roleController::class,'view']);
Route::get('/role/add',[roleController::class,'create']);
Route::post('/role/post',[roleController::class,'addupdate']);
Route::get('/role/edit/{id}',[roleController::class,'edit']);
Route::get('/role/delete/{id}',[roleController::class,'delete']);


##  FRANCHISE ROUTES    ##

Route::group(['prefix' => 'user'], function(){
Route::group(['middleware' => 'user'],function(){


Route::get('/dashboard/',[userController::class,'userdashboard']);
##  FRANCHISE  -- ORDERS    ##
Route::get('/order',[orderController::class,'view']);
Route::get('/order/add',[orderController::class,'create']);
Route::get('/order/{id}', [orderController::class,'edit']);
Route::get('/order/edit/{id}', [adminOrderController::class,'edit']);
Route::post('/order/updateOrder',[adminOrderController::class,'updateOrder']);
Route::get('/order/view/{id}', [adminOrderController::class,'orderview']);
Route::post('/order/post',[orderController::class,'addupdate']);
Route::post('/order/getProduct',[orderController::class,'getProduct']);
Route::post('/order/getTaxes',[orderController::class,'getTaxes']);
Route::get('/order/delete/{id}',[orderController::class,'delete']);



Route::get('/order/invoice/{id}',[orderController::class,'orderInvoice']);
Route::get('/purchase-order',[purchaseOrderController::class,'view']);

##  FRANCHISE --  INWARDS ##
Route::get('/inward',[inwardController::class,'view']);
Route::get('/inward/add',[inwardController::class,'create']);
Route::get('/stock',[inwardController::class,'addstock']);
Route::post('/inward/post',[inwardController::class,'store']);
Route::post('/stock/post',[inwardController::class,'storestock']);
Route::get('/inward/view/{id}',[inwardController::class,'viewInward']);
Route::get('/inward/edit/{id}',[inwardController::class,'edit']);
Route::post('/inward/getProductByVendorId',[inwardController::class,'getProductByVendorId']);
Route::post('/inward/getProduct',[inwardController::class,'getProduct']);
Route::get('/inward/invoice/{id}',[inwardController::class,'inwardInvoice']);

##  FRANCHISE --    OUTWARDS  ##
Route::get('/outward',[outwardController::class,'view']);
Route::get('/outward/add',[outwardController::class,'create']);
Route::get('/outward/edit/{id}', [outwardController::class,'edit']);
Route::get('/outward/view/{id}', [outwardController::class,'viewOutward']);
Route::post('/outward/post',[outwardController::class,'addupdate']);
Route::get('/outward/print/{id}',[outwardController::class,'invoice']);
Route::get('/outward/delete/{id}',[orderController::class,'delete']);
Route::get('/vendor-order',[purchaseOrderController::class,'view']);


##  FRANCHISE   --  RETURNS     ##
Route::get('/return',[returnController::class,'view']);
Route::get('/return/add',[returnController::class,'create']);
Route::get('/return/edit/{id}', [returnController::class,'edit']);
Route::get('/return/view/{id}', [returnController::class,'viewOutward']);
Route::post('/return/post',[returnController::class,'addupdate']);
Route::get('/return/print/{id}',[returnController::class,'invoice']);
Route::get('/return/delete/{id}',[orderController::class,'delete']);
Route::get('/vendor-order',[purchaseOrderController::class,'view']);

## FRANCHISE    --  REPORTS   ##
Route::get('/report/order',[orderController::class,'report']);
Route::post('/report/order',[orderController::class,'report']);
Route::get('/report/opening-stock',[departmentController::class,'opening_stock']);
Route::post('/report/opening-stock',[departmentController::class,'opening_stock']);
Route::get('/report/closing-stock',[departmentController::class,'closing_stock']);
Route::post('/report/closing-stock',[departmentController::class,'closing_stock']);
Route::get('/report/stock-ledger',[departmentController::class,'stock_ledger']);
Route::post('/report/stock-ledger',[departmentController::class,'stock_ledger']);
Route::get('/report/inward',[inwardController::class,'report']);
Route::post('/report/inward',[inwardController::class,'report']);
Route::get('/report/outward',[outwardController::class,'report']);
Route::post('/report/outward',[outwardController::class,'report']); 
});  
});
});



## VENDOR SCREEN ROUTES ##
Route::group(['prefix' => 'vendor'], function(){
Route::get('/login',[vendorController::class,'login']);
Route::post('/login',[vendorController::class,'login']);
Route::group(['middleware' => 'vendor'], function(){
Route::get('/dashboard',[vendorController::class,'home']);
Route::get('/order',[vendorController::class,'order']);
Route::post('/order',[vendorController::class,'order']);
Route::get('/vieworder/{id}',[orderController::class,'view']);
Route::get('/vendor-order/{id}',[purchaseOrderController::class,'edit']);
Route::post('/vendor-order/post', [purchaseOrderController::class,'updatePurchaseOrder']);
});
});


Route::get('/report/daily_opening_stock',[departmentController::class,'daily_opening_stock']);


require __DIR__.'/auth.php';


 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });
 
 Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 });
 
 
 Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });
 
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('view:clear');
     return 'View cache cleared';
 });
