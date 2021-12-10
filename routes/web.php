<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\taxController;
use App\Http\Controllers\categoryController;
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

##  ORDER ROUTES ##
//Route::get('/order',[orderController::class,'view']);
// Route::get('/order/add',[orderController::class,'create']);
// Route::get('/order/{id}', [orderController::class,'edit']);
// Route::post('/order/post',[orderController::class,'addupdate']);
// Route::post('/order/getProduct',[orderController::class,'getProduct']);
// Route::post('/order/getTaxes',[orderController::class,'getTaxes']);
// Route::get('/order/delete/{id}',[orderController::class,'delete']);
// Route::get('/order/invoice',[orderController::class,'invoice']);

##  ADMIN ORDER ROUTES ##
Route::get('/admin-order',[adminOrderController::class,'view']);
Route::get('/place-purchase-order/{id}', [adminOrderController::class,'getOrderDetails']);
Route::post('/admin-order/updateStatus',[adminOrderController::class,'updateStatus']);
Route::post('/admin-order/place-purhcase-order',[adminOrderController::class,'placePurchaseOrder']);
Route::get('/admin-order/{id}', [adminOrderController::class,'edit']); //display same view from order controller
Route::post('/admin-order/getVendorsByProduct', [adminOrderController::class,'getVendorsByProduct']);

## VENDOR ORDER ROUTES ##
Route::get('/vendor-order',[purchaseOrderController::class,'view']);
Route::get('/vendor-order/{id}',[purchaseOrderController::class,'edit']);
// Route::get('/purchase-order',[purchaseOrderController::class,'view']);
Route::post('/vendor-order/post', [purchaseOrderController::class,'updatePurchaseOrder']);




##  INWARD ROUTES ##
Route::get('/inward',[inwardController::class,'view']);
Route::get('/inward/add',[inwardController::class,'create']);
Route::post('/inward/store',[inwardController::class,'store']);
Route::post('/inward/getProductByVendorId',[inwardController::class,'getProductByVendorId']);


##  OUTWARD ROUTES ##
Route::get('/outward',[outwardController::class,'view']);
Route::get('/outward/add',[outwardController::class,'create']);
Route::get('/outward/{id}', [outwardController::class,'edit']);
Route::post('/order/getProduct',[orderController::class,'getProduct']);
Route::post('/outward/post',[outwardController::class,'addupdate']);
Route::get('/outward/delete/{id}',[orderController::class,'delete']);
Route::get('/outward/invoice',[outwardController::class,'invoice']);

## REPORTS ROUTES   ##
Route::get('/report/order',[orderController::class,'report']);
Route::get('/report/purchase-order',[purchaseOrderController::class,'report']);
Route::get('/report/order-item',[orderController::class,'order_item_report']);


## RETURN GOODS ## 
Route::get('/return',function(){
    return view('admin.return_goods.index');
});

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




    Route::get('/dashboard/',function(){
        return view('user.dashboard');
    });
##  FRANCHISE  -- ORDERS    ##
Route::get('/order',[orderController::class,'view']);
Route::get('/order/add',[orderController::class,'create']);
Route::get('/order/{id}', [orderController::class,'edit']);
Route::post('/order/post',[orderController::class,'addupdate']);
Route::post('/order/getProduct',[orderController::class,'getProduct']);
Route::post('/order/getTaxes',[orderController::class,'getTaxes']);
Route::get('/order/delete/{id}',[orderController::class,'delete']);
Route::get('/order/invoice',[orderController::class,'invoice']);

##  FRANCHISE --  INWARDS ##
Route::get('/inward',[inwardController::class,'view']);
Route::get('/inward/add',[inwardController::class,'create']);
Route::post('/inward/store',[inwardController::class,'store']);
Route::get('/product/edit/{id}',[productController::class,'edit']);
Route::post('/inward/getProductByVendorId',[inwardController::class,'getProductByVendorId']);

##  FRANCHISE --    OUTWARDS  ##
Route::get('/outward',[outwardController::class,'view']);
Route::get('/outward/add',[outwardController::class,'create']);
Route::get('/outward/{id}', [outwardController::class,'edit']);
Route::post('/order/getProduct',[orderController::class,'getProduct']);
Route::post('/outward/post',[outwardController::class,'addupdate']);
Route::get('/outward/delete/{id}',[orderController::class,'delete']);
Route::get('/outward/invoice',[outwardController::class,'invoice']);

## FRANCHISE    --  REPORTS   ##
Route::get('/report/order',[orderController::class,'report']);
Route::post('/report/order',[orderController::class,'report']);
Route::get('/report/inward',[inwardController::class,'report']);
Route::post('/report/inward',[inwardController::class,'report']);
Route::get('/report/outward',[outwardController::class,'report']);
Route::post('/report/outward',[outwardController::class,'report']); 
});  
});
});
## VENDOR SCREEN ROUTES ##
Route::get('invoice',function(){
    return view('admin.order.invoice');
});




require __DIR__.'/auth.php';
