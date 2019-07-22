<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Countries and Cities
*/
Route::middleware('cors')->get('countries', 'Api\BaseController@countries');
Route::middleware('cors')->get('city/{id}', 'Api\BaseController@cities');

/*
User Routes
*/

// Route::post('/user/register', 'Api\UserController@register');
Route::middleware('cors')->post('/user/login', 'Api\UserController@login');
/* 
** Global Middleware for all Routes
*/
Route::group(['middleware' => ['cors','auth:api']], function () {


/*
Customer Routes
*/
Route::get('/customer/all', 'Api\CustomerController@index');
Route::post('/customer/create', 'Api\CustomerController@store');
Route::get('/customer/show/{id}', 'Api\CustomerController@show');
Route::post('/customer/update/{id}', 'Api\CustomerController@update');
Route::post('/customer/delete/{id}', 'Api\CustomerController@destroy');
Route::post('/customer/destroy', 'Api\CustomerController@delete');
/*
Customer Address Routes
*/
Route::get('/address/all', 'Api\AddressController@index');
Route::post('/address/create', 'Api\AddressController@store');
Route::get('/address/show/{id}', 'Api\AddressController@show');
Route::post('/address/update/{id}', 'Api\AddressController@update');
Route::post('/address/delete/{id}', 'Api\AddressController@destroy');
Route::post('/address/destroy', 'Api\AddressController@delete');
/*
Customer phone Routes
*/
Route::get('/phonenumber/all', 'Api\PhoneNumberController@index');
Route::post('/phonenumber/create', 'Api\PhoneNumberController@store');
Route::get('/phonenumber/show/{id}', 'Api\PhoneNumberController@show');
Route::post('/phonenumber/update/{id}', 'Api\PhoneNumberController@update');
Route::post('/phonenumber/delete/{id}', 'Api\PhoneNumberController@destroy');
Route::post('/phonenumber/destroy', 'Api\PhoneNumberController@delete');
/*
Supplier Routes
*/
Route::post('/supplier/create', 'Api\SupplierController@store');
Route::get('/supplier/all', 'Api\SupplierController@index');
Route::get('/supplier/show/{id}', 'Api\SupplierController@show');
Route::post('/supplier/update/{id}', 'Api\SupplierController@update');
Route::post('/supplier/delete/{id}', 'Api\SupplierController@destroy');
Route::post('/supplier/destroy', 'Api\SupplierController@delete');
/*
Category Routes
*/
Route::post('/category/create', 'Api\CategoryController@store');
Route::get('/category/all', 'Api\CategoryController@index');
Route::get('/category/show/{id}', 'Api\CategoryController@show');
Route::post('/category/update/{id}', 'Api\CategoryController@update');
Route::post('/category/delete/{id}', 'Api\CategoryController@destroy');
Route::post('/category/destroy', 'Api\CategoryController@delete');
/*
SubCategory Routes
*/
Route::post('/subcategory/create', 'Api\SubcategoryController@store');
Route::get('/subcategory/all', 'Api\SubcategoryController@index');
Route::get('/subcategory/show/{id}', 'Api\SubcategoryController@show');
Route::post('/subcategory/update/{id}', 'Api\SubcategoryController@update');
Route::post('/subcategory/delete/{id}', 'Api\SubcategoryController@destroy');
Route::post('/subcategory/destroy', 'Api\SubcategoryController@delete');
/*
Warehouse Routes
*/
Route::post('/warehouse/create', 'Api\WarehouseController@store');
Route::get('/warehouse/all', 'Api\WarehouseController@index');
Route::get('/warehouse/show/{id}', 'Api\WarehouseController@show');
Route::post('/warehouse/update/{id}', 'Api\WarehouseController@update');
Route::post('/warehouse/delete/{id}', 'Api\WarehouseController@destroy');
Route::post('/warehouse/destroy', 'Api\WarehouseController@delete');
/*
Locator Routes
*/
Route::post('/locator/create', 'Api\LocatorController@store');
Route::get('/locator/all', 'Api\LocatorController@index');
Route::get('/locator/show/{id}', 'Api\LocatorController@show');
Route::post('/locator/update/{id}', 'Api\LocatorController@update');
Route::post('/locator/delete/{id}', 'Api\LocatorController@destroy');
Route::post('/locator/destroy', 'Api\LocatorController@delete');
/*
InventoryItem Routes
*/
Route::post('/item/create', 'Api\InventoryItemController@store');
Route::get('/item/all', 'Api\InventoryItemController@index');
Route::get('/item/show/{id}', 'Api\InventoryItemController@show');
Route::post('/item/update/{id}', 'Api\InventoryItemController@update');
Route::post('/item/delete/{id}', 'Api\InventoryItemController@destroy');
Route::post('/item/destroy', 'Api\InventoryItemController@delete');
/*
Unit of Measure Routes
*/
Route::post('/unitofmeasure/create', 'Api\UnitofMeasureController@store');
Route::get('/unitofmeasure/all', 'Api\UnitofMeasureController@index');
Route::get('/unitofmeasure/show/{id}', 'Api\UnitofMeasureController@show');
Route::post('/unitofmeasure/update/{id}', 'Api\UnitofMeasureController@update');
Route::post('/unitofmeasure/delete/{id}', 'Api\UnitofMeasureController@destroy');
Route::post('/unitofmeasure/destroy', 'Api\UnitofMeasureController@delete');
/*
Purchase Order Routes
*/
Route::post('/puchaseOrder/create', 'Api\PurchaseOrderController@store');
Route::get('/puchaseOrder/all', 'Api\PurchaseOrderController@index');
Route::get('/puchaseOrder/show/{id}', 'Api\PurchaseOrderController@show');
Route::post('/puchaseOrder/update/{id}', 'Api\PurchaseOrderController@update');
Route::post('/puchaseOrder/delete/{id}', 'Api\PurchaseOrderController@destroy');
Route::post('/puchaseOrder/destroy', 'Api\PurchaseOrderController@delete');

/*
Recieving Transaction Routes
*/
Route::post('/recievingTransaction/create', 'Api\PurchaseOrderController@store');
Route::get('/recievingTransaction/all', 'Api\PurchaseOrderController@index');
Route::get('/recievingTransaction/show/{id}', 'Api\PurchaseOrderController@show');
Route::post('/recievingTransaction/update/{id}', 'Api\PurchaseOrderController@update');
Route::post('/recievingTransaction/delete/{id}', 'Api\PurchaseOrderController@destroy');
/*
Payment Term Routes
*/
Route::get('/paymentterm/all', 'Api\PaymentTermController@index');
Route::post('/paymentterm/create', 'Api\PaymentTermController@store');
Route::get('/paymentterm/show/{id}', 'Api\PaymentTermController@show');
Route::post('/paymentterm/update/{id}', 'Api\PaymentTermController@update');
Route::post('/paymentterm/delete/{id}', 'Api\PaymentTermController@destroy');
Route::post('/paymentterm/destroy', 'Api\PaymentTermController@delete');


});



// php -S 127.0.0.1:8000 -t public -f serve.php.

