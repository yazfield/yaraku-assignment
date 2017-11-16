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

Route::get('/', 'BookListController@index')->name('home');
Route::post('/lists', 'BookListController@store')->name('add_book_list');
Route::get('/lists/{bookList}', 'BookListController@show')->name('book_list');
Route::delete('/lists/{bookList}/detach', 'BookListController@detachBook')
  ->name('detach_book');
Route::post('/lists/{bookList}', 'BookListController@attachBook')->name('attach_book');

Route::post('/lists/{bookList}/nonexisting', 'BookListController@attachNonexistingBook')
  ->name('attach_nonexisting_book');