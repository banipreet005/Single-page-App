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

Route::get('/', function () { return view('welcome'); })->name('welcome');
/* We use HTTP Methods to define actions for GET, POST, PUT and DELETE */
Route::get('/animals','AnimalController@findAll')->name('findAnimals');
Route::get('/animals/{id}','AnimalController@find')->name('findAnimal');
Route::post('/animals','AnimalController@create')->name('createAnimal');
Route::post('/updateAnimal','AnimalController@update')->name('updateAnimal');
Route::delete('/animals','AnimalController@delete')->name('deleteAnimal');

