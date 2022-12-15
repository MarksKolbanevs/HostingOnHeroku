<?php

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


Route::group(['prefix' => 'v1','namespace'=>'App\Http\Controllers\Api\V1'],function(){
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('storages',StorageController::class);
    Route::apiResource('passwords',PasswordController::class);
    Route::apiResource('rooms',RoomController::class);
    Route::apiResource('mails',MailController::class);
    Route::apiResource('categories',CategoryController::class);
    Route::get('users/admin/{id}','UserController@checkForAdmin');
    Route::get('users/unread/{id}','UserController@unreadCount');
    Route::post('users/auth/login','UserController@login');
    Route::get('mails/search/{roomid}','MailController@search');
    Route::get('rooms/search','RoomController@search');
    Route::get('rooms/mails/{id}','RoomController@mails');
    Route::get('categories/every/{id}', 'CategoryController@every');
    Route::get('categories/unread/{id}', 'CategoryController@unread');
    Route::get('categories/important/{id}', 'CategoryController@important');
    Route::get('categories/deferred/{id}', 'CategoryController@deferred');
    Route::post('categories/unread/{id}', 'CategoryController@unreadStore');
    Route::post('categories/important/{id}', 'CategoryController@importantStore');
    Route::post('categories/deferred/{id}', 'CategoryController@deferredStore');
    Route::get('categories/deferred/check/{id}', 'CategoryController@deferredCheck');
    Route::get('categories/important/check/{id}', 'CategoryController@importantCheck');
    Route::get('categories/search/every/{id}', 'CategoryController@searchEvery');
    Route::get('categories/search/unread/{id}', 'CategoryController@searchUnread');
    Route::get('categories/search/important/{id}', 'CategoryController@searchImportant');
    Route::get('categories/search/deferred/{id}', 'CategoryController@searchDeferred');
    Route::delete('admin/user/{email}', 'AdminController@deleteUser');
    Route::get('admin/mail', 'AdminController@getMessage');
    Route::patch('admin/user', 'AdminController@patchUser');
    //Route::delete('admin/mail', 'AdminController@patchUser');
});