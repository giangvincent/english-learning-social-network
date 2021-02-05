<?php
use App\Http\Controllers\JsonController;
use App\Models\User;

Route::get('/policies-and-service-terms', function () {
    return view('static_page');
});
Route::get('/share/{postId}', function ($postId) {
    $postJson = new JsonController();
    $data = $postJson->getPost($postId);

    if (!is_array($data)) {
        $data = json_decode($data, true)[0];
    }
    return view('share', ['data' => $data]);
});
Route::get('/', function () {
    return view('welcome');
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
