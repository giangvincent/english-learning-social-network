<?php

use App\Http\Controllers\JsonController;
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
Route::get('/share', function () {
    return view('share');
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
});
