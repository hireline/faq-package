<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'CategoryController@all')->name('categories.all');
Route::get('/search', 'PostController@search')->name('posts.search');
Route::get('/partials/search', 'PostController@searchPartial')->name('posts.search.partial');
Route::group(['prefix' => 'posts', 'middleware' => config('faq.admin_middleware')], function(){
	Route::get('/', 'PostController@index')->name('dashboard');
    Route::get('/create', 'PostController@create')->name('posts.create');
    Route::post('/create', 'PostController@store')->name('posts.store');
    Route::get('/edit/{post_id}', 'PostController@edit')->name('posts.edit');
    Route::post('/update/{post_id}', 'PostController@update')->name('posts.update');
    Route::get('/toggle', 'PostController@toggle')->name('posts.toggle');
});
Route::get('/posts/{slug}', 'PostController@show')->name('posts.show');

Route::group(['prefix' => 'categories', 'middleware' => config('faq.admin_middleware')], function(){
    Route::get('/', 'CategoryController@index')->name('categories.index');
    Route::post('/store', 'CategoryController@store')->name('categories.store');
    Route::post('/update', 'CategoryController@update')->name('categories.update');
});
Route::get('categories/{slug}', 'CategoryController@show')->name('categories.show');

Route::group(['prefix' => 'resources', 'middleware' => config('faq.admin_middleware')], function(){
    Route::get('/', 'ResourceController@show')->name('resources.show');
    Route::post('/upload', 'ResourceController@store')->name('resources.store');
});