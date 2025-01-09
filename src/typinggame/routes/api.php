<?php
    use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/drill/score/{id}', 'Api\DrillsController@highScore')->name('highScore');


Route::post('/myscore/{id}', 'Api\DrillsController@score')->name('api.score');


Route::get('/lists', 'Api\DrillsController@getDrills')->name('api.get');


