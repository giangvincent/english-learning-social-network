<?php

use App\Http\Controllers\JsonController;

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
Route::post('new-contact', 'ContactController@handleCreateContact');

Route::get('user-detail/{id}', 'UserController@details');
Route::get('uploaded-posts/{id}', 'UserController@uploadedPosts');
Route::group(['middleware' => 'auth:api'], function () {

    Route::post('update-info', 'UserController@updateInfo');
    Route::post('change-password', 'UserController@changePassword');
    Route::post('change-avatar', 'UserController@changeAvatar');
    Route::post('change-cover', 'UserController@changeCover');

    Route::get('bagged-posts', 'UserController@baggedPosts');
    Route::post('req-interact', 'UserController@interactPost');

    Route::post('create-post', 'PostController@CreatePost');
    Route::post('update-post', 'PostController@updatePost');
    Route::post('delete-post', 'PostController@deletePost');
    Route::post('report-post', 'PostController@reportPost');

    Route::post('upload-image', 'TempController@uploadTempImg');

    Route::post('update-learning-progress', 'UserController@SaveLearnt');

    Route::get('seen-notification/{slug}', 'UserController@seenNotification');

    // test api
    Route::get('get-calculate', 'UserController@calculateLearningDay');
});

Route::get('feed-home', 'FeedController@home');
Route::get('feed-category/{slug}', 'FeedController@feedCategory');
Route::get('feed-tag/{slug}', 'FeedController@feedTag');

use Illuminate\Support\Facades\Route;

Route::get('/share/{postId}', function ($postId) {
    $postJson = new JsonController();
    $data = $postJson->getPost($postId);

    if (!is_array($data)) {
        $data = json_decode($data, true)[0];
    }
    return view('share', ['data' => $data]);
});

Route::group([
    'prefix' => 'get-json',
], function () {
    Route::get('post/{id}', [JsonController::class, 'getPost']);
    Route::get('category/{slug}', [JsonController::class, 'getCategory']);
    Route::get('categories', [JsonController::class, 'getCategories']);
    Route::get('tag/{slug}', [JsonController::class, 'getTag']);
    Route::get('tags', [JsonController::class, 'getTags']);

    Route::get('progress/{link}', [JsonController::class, 'getUserProgress']);

    Route::get('notification/{link}', [JsonController::class, 'getUserNotification']);
});
