<?php

use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
}); */

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user-detail', 'UserController@details');
    Route::post('create-post', 'PostController@CreatePost');
    Route::post('upload-image', 'TempController@uploadTempImg');

    Route::get('uploaded-posts', 'UserController@uploadedPosts');
    Route::get('bagged-posts', 'UserController@baggedPosts');

    Route::post('req-interact', 'UserController@interactPost');
});

Route::get('feed-home', 'FeedController@home');
Route::get('feed-category/{slug}', 'FeedController@feedCategory');
Route::get('feed-tag/{slug}', 'FeedController@feedTag');
