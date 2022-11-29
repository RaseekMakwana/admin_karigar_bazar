<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CosmaticController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorServiceController;
use App\Http\Controllers\VendorBasicRegistrationController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageConverterController;

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

Route::get('/', [AuthenticationController::class, 'login']);
Route::get('login', [AuthenticationController::class, 'login']);
Route::get('logout', [AuthenticationController::class, 'logout']);
Route::post('authentication/verification', [AuthenticationController::class, 'verification']);

Route::post('cosmatic/get_cities_by_state_id', [CosmaticController::class, 'get_cities_by_state_id']);
Route::post('cosmatic/get_area_by_city_id', [CosmaticController::class, 'get_area_by_city_id']);
Route::post('cosmatic/get_category_by_vendor_type_id', [CosmaticController::class, 'get_category_by_vendor_type_id']);
Route::post('cosmatic/get_services_by_category_id', [CosmaticController::class, 'get_services_by_category_id']);

Route::get('temp_data', [DataController::class, 'temp_data']);


// Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Vendor Core Data Registration
    Route::get('vendor_basic_registration/manage', [VendorBasicRegistrationController::class, 'manage']);
    Route::post('vendor_basic_registration/load_manage_data', [VendorBasicRegistrationController::class, 'load_manage_data']);
    Route::post('vendor_basic_registration/detail_view', [VendorBasicRegistrationController::class, 'detail_view']);
    Route::post('vendor_basic_registration/approve_reject_delete_action', [VendorBasicRegistrationController::class, 'approve_reject_delete_action']);
    // Route::get('vendor/create_by_vendor/{id}', [VendorController::class, 'createByVendor']);
    // Route::post('vendor/store_by_vendor', [VendorController::class, 'storeByVendor']);

    // User
    Route::get('user/manage', [UserController::class, 'index']);
    Route::post('user/load_manage_data', [UserController::class, 'load_manage_data']);
    Route::post('user/delete', [UserController::class, 'delete']);
    Route::post('user/permanent_delete', [UserController::class, 'permanent_delete']);
    Route::get('user/view/{user_id}', [UserController::class, 'view']);
    Route::get('user/view/vendor/project/{user_id}', [UserController::class, 'project']);


    // Vendor
    Route::get('vendor/manage', [VendorController::class, 'index']);
    Route::get('vendor/create', [VendorController::class, 'create']);
    Route::get('vendor/create/{id}', [VendorController::class, 'create']);
    Route::post('vendor/update', [VendorController::class, 'update']);
    Route::get('vendor/edit/{user_id}', [VendorController::class, 'edit']);
    Route::post('vendor/store', [VendorController::class, 'store']);
    Route::post('vendor_create_edit/check_vendor_mobile_exist', [VendorController::class, 'check_vendor_mobile_exist']);
    Route::post('vendor/delete', [VendorController::class, 'delete']);
    Route::post('vendor/load_manage_data', [VendorController::class, 'load_manage_data']);

    // City Module
    Route::get('city/create', [CityController::class, 'create']);
    Route::post('city/store', [CityController::class, 'store']);
    Route::get('city/edit/{id}', [CityController::class, 'edit']);
    Route::get('city/manage', [CityController::class, 'manage']);
    Route::post('city/delete', [CityController::class, 'delete']);
    Route::post('city/load_manage_data', [CityController::class, 'load_manage_data']);
    Route::post('city/load_manage_data', [CityController::class, 'load_manage_data']);

    // Area Module
    Route::get('area/create', [AreaController::class, 'create']);
    Route::post('area/store', [AreaController::class, 'store']);
    Route::get('area/edit/{state_id}/{city_id}', [AreaController::class, 'edit']);
    Route::get('area/refmanage/{state_id}/{city_id}', [AreaController::class, 'manage']);
    Route::get('area/manage', [AreaController::class, 'manage']);
    Route::post('area/delete', [AreaController::class, 'delete']);
    Route::post('area/load_manage_data', [AreaController::class, 'load_manage_data']);

    // Category Module
    Route::get('category/manage', [CategoryController::class, 'manage']);
    Route::post('category/load_manage_data', [CategoryController::class, 'load_manage_data']);
    Route::get('category/create', [CategoryController::class, 'create']);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::get('category/edit/{vendor_type_id}', [CategoryController::class, 'edit']);
    Route::post('category/update', [CategoryController::class, 'update']);
    Route::post('category/delete', [CategoryController::class, 'delete']);

    // Service Module
    Route::get('service/manage', [ServiceController::class, 'manage']);
    Route::post('service/load_manage_data', [ServiceController::class, 'load_manage_data']);
    Route::get('service/create', [ServiceController::class, 'create']);
    Route::post('service/store', [ServiceController::class, 'store']);
    Route::get('service/edit/{category_id}', [ServiceController::class, 'edit']);
    Route::post('service/update', [ServiceController::class, 'update']);
    Route::post('service/delete', [ServiceController::class, 'delete']);

    // Vendor Service Module
    Route::get('vendor_service/manage/{user_id}', [VendorServiceController::class, 'manage']);
    Route::get('vendor_service/create/{user_id}', [VendorServiceController::class, 'create']);
    Route::post('vendor_service/store', [VendorServiceController::class, 'store']);
    Route::post('vendor_service/load_manage_data', [VendorServiceController::class, 'load_manage_data']);
    Route::get('vendor_service/edit/{user_id}/{category_id}', [VendorServiceController::class, 'edit']);
    Route::post('vendor_service/delete', [VendorServiceController::class, 'delete']);
    
    Route::get('language-converter', [LanguageConverterController::class, 'index']);
    Route::post('language-converter/convert', [LanguageConverterController::class, 'convert']);
    Route::get('language-input-translate', [LanguageConverterController::class, 'languageInputTranslate']);
// });
