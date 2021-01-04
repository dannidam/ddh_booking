<?php

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


/*Foodbooking START*/
/*Route::get('foodbooking/bookfood&shop={name}&shop_id={id}', 'Foodbooking\main@main');*/
Route::get('foodbooking/shop={name}/shop_id={id}/m={month}', 'foodbooking\main@index');
Route::get('getFoodTables', 'foodbooking\main@getTables');
/*Foodbooking END*/
