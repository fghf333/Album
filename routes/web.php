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

//HOME
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getHome']);

//UPLOADING
Route::get('upload/{AlbumID?}', ['as' => 'upload_form', 'uses' => 'UploadController@getForm']);
Route::post('upload', ['as' => 'upload_file', 'uses' => 'UploadController@upload']);
Route::get('tags','UploadController@tags');
Route::get('add-tags/{imageID}','UploadController@addtags');

//IMAGE EDITOR
Route::get('edit-image/{imageID?}', ['as' => 'edit_image_form', 'uses' => 'UploadController@getEditForm']);
Route::post('edit-image/{imageID}', ['as' => 'edit_image', 'uses' => 'UploadController@upload']);
Route::delete('delete-image/{imageID}', ['as' => 'delete_image', 'uses' => 'UploadController@deleteImage']);

//ALBUM
Route::get('albums', ['as' => 'albums_list', 'uses' => 'AlbumController@getList']);
Route::get('edit-album/{AlbumID}', ['as' => 'edit_album_form', 'uses' => 'AlbumController@getEditForm']);
Route::post('edit-album/{AlbumID}', ['as' => 'edit_album', 'uses' => 'AlbumController@editAlbum']);
Route::get('create-album', ['as' => 'create_album_form', 'uses' => 'AlbumController@getForm']);
Route::post('create-album', ['as' => 'create_album', 'uses' => 'AlbumController@createAlbum']);
Route::delete('delete-album/{AlbumID}', ['as' => 'delete_album', 'uses' => 'AlbumController@deleteAlbum']);

//LIST OF IMAGES
Route::get('images-list/{AlbumID?}', ['as' => 'images-list', 'uses' => 'ImagesListController@getList']);

//USER PAGE
Route::get('profile/{UserID}', ['as' => 'profile', 'uses' => 'ProfileController@getProfile']);
Route::post('change-password', ['as' => 'password_change', 'uses' => 'ProfileController@changePassword']);
Route::get('charts','ProfileController@charts');

// Authentication Routes...
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Password Reset Routes...
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => '', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

// Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', ['as' => '', 'uses' => 'Auth\RegisterController@register']);

//Family
Route::get('family/{FamilyID?}', ['as' => 'family_list', 'uses' => 'Family\FamilyController@getFamilyList']);

//TEST ROUTE
Route::get('test', ['as' => 'test_form', 'uses' => 'TestController@test']);
Route::post('test', ['as' => 'test_upload', 'uses' => 'TestController@upload']);
