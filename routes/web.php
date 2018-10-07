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

Route::get('/', function () {
    return view('index');
});

Route::get('/image','ImageController@index')->name('image.index');
Route::post('/image/uploads','ImageController@UploadImage')->name("image.uploads");
Route::post('/image/convert','ImageController@Convert')->name("image.convert");

Route::get('/video','VideoController@index')->name('video.index');
Route::post('/video/uploads','VideoController@UploadVideo')->name("video.uploads");
Route::post('/video/convert','VideoController@Convert')->name("video.convert");

Route::get('/audio','AudioController@index')->name('audio.index');
Route::post('/audio/uploads','AudioController@UploadAudio')->name("audio.uploads");
Route::post('/audio/convert','AudioController@Convert')->name("audio.convert");

