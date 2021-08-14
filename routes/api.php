<?php

use App\Http\Controllers\Api\ArticlesController;
use Illuminate\Http\Request;
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

/*
 * Получение списка постов из таблицы articles (GET)
 * URI: {host}/api/articles
 */

Route::get('/articles', [ArticlesController::class, 'index']);

/*
 * Получение одного поста из таблицы articles по ID
 * URI: {host}/api/articles/{id}
 */

Route::get('/articles/{id}', [ArticlesController::class, 'show']);

/*
 * Добавление нового поста в таблицу articles
 * URI: {host}/api/articles
 */

Route::post('/articles', [ArticlesController::class, 'store']);

/*
 * Изменение поста из таблицы articles
 * URI: {host}/api/articles/{id}
 */

Route::put('/articles/{id}', [ArticlesController::class, 'update']);

/*
 * Удаление поста по ID из таблицы articles
 * URI: {host}/api/articles/{id}
 */

Route::delete('/articles/{id}', [ArticlesController::class, 'destroy']);
