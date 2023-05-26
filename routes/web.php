<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StoreCategoryController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



//city
Route::get('/view-city',[CityController::class,'viewCity'])->name('admin.viewCity');
Route::post('/add-city',[CityController::class,'addCity'])->name('admin.addCity');
Route::get('/toggle-city/{id}',[CityController::class,'toggleCity'])->name('admin.toggleCity');
Route::post('/update-city',[CityController::class,'updateCity'])->name('admin.updateCity');
Route::get('/delete-City/{id}',[CityController::class,'deleteCity'])->name('admin.deleteCity');
Route::get('/export-City',[CityController::class,'exportCity'])->name('admin.exportCity');
Route::post('/import-City',[CityController::class,'importCity'])->name('admin.importCity');

//Item

Route::get('/Item',[ItemController::class,'viewItem'])->name('admin.viewItem');
Route::post('/add-item',[ItemController::class,'additem'])->name('admin.additem');
Route::get('/toggle-item/{id}',[ItemController::class,'toggleitem'])->name('admin.toggleitem');
Route::post('/update-item',[ItemController::class,'updateitem'])->name('admin.updateitem');
Route::get('/delete-item/{id}',[ItemController::class,'deleteitem'])->name('admin.deleteitem');
Route::get('/export-item',[ItemController::class,'exportItem'])->name('admin.exportItem');
Route::post('/import-item',[ItemController::class,'importItem'])->name('admin.importItem');


//store
Route::get('/view-store',[StoreController::class,'viewStore'])->name('admin.viewStore');
Route::post('/add-store',[StoreController::class,'addStore'])->name('admin.addStore');
Route::get('/toggle-store/{id}',[StoreController::class,'toggleStore'])->name('admin.toggleStore');
Route::post('/update-store',[StoreController::class,'updateStore'])->name('admin.updateStore');
Route::get('/delete-store/{id}',[StoreController::class,'deleteStore'])->name('admin.deleteStore');
Route::get('/export-store',[StoreController::class,'exportStore'])->name('admin.exportStore');
Route::post('/import-store',[StoreController::class,'importStore'])->name('admin.importStore');


//Store category
Route::get('/view-store-category',[StoreCategoryController::class,'viewStoreCategory'])->name('admin.viewStoreCategory');
Route::post('/add-store-category',[StoreCategoryController::class,'addstore_category'])->name('admin.addstore_category');
Route::get('/toggle-store-category/{id}',[StoreCategoryController::class,'togglestore_category'])->name('admin.togglestore_category');
Route::post('/update-store-category',[StoreCategoryController::class,'updatestore_category'])->name('admin.updatestore_category');
Route::get('/delete-store-category/{id}',[StoreCategoryController::class,'deletestore_category'])->name('admin.deletestore_category');


//datatable
Route::get('/datable-city',[DatatableController::class,'cityDatatable'])->name('cityDatatable');
Route::get('/datable-item',[DatatableController::class,'itemDatatable'])->name('itemDatatable');
Route::get('/datable-store-category',[DatatableController::class,'storeCategoryDatatable'])->name('storeCategoryDatatable');
Route::get('/datable-store',[DatatableController::class,'storeDatatable'])->name('storeDatatable');


require __DIR__.'/auth.php';


