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
/*
|-------------------------------------------------------------------------------
| Register a New User
|-------------------------------------------------------------------------------
| URL:            /api/register
| Controller:     Auth\AuthController@register
| Method:         POST
| Description:    Registration new user
*/
Route::post('register', 'Auth\AuthController@register');
/*
|-------------------------------------------------------------------------------
| Login User
|-------------------------------------------------------------------------------
| URL:            /api/login
| Controller:     Auth\AuthController@login
| Method:         POST
| Description:    Login User
*/
Route::post('login', 'Auth\AuthController@login');
/*
|-------------------------------------------------------------------------------
| Recover Password User
|-------------------------------------------------------------------------------
| URL:            /api/recover
| Controller:     Auth\AuthController@recover
| Method:         POST
| Description:    Recover password User send link on Email
*/
Route::post('recover', 'Auth\AuthController@recover');

Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('logout', 'AuthController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
    /*
    |-------------------------------------------------------------------------------
    | Updates a User's Profile
    |-------------------------------------------------------------------------------
    | URL:            /api/user
    | Controller:     API\UsersController@putUpdateUser
    | Method:         PUT
    | Description:    Updates the authenticated user's profile
    */
    Route::put('user', 'API\UsersController@putUpdateUser');
});

Route::apiResource('places', 'BookController');
Route::post('places/{place}/ratings', 'RatingController@store');