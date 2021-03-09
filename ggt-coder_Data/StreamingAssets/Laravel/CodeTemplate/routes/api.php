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

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                /*// 登录
                Route::post('authorizations', ['AuthorizationsController@store'])
                    ->name('api.authorizations.store');
                // 刷新token
                Route::put('authorizations/current', 'AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');*/
            });

        Route::middleware([
            'throttle:' . config('api.rate_limits.access'),
            // 'auth:api' // 用户验证
        ])
            ->group(function () {
                /*// 用户列表
                Route::get('users', 'UsersController@index')->name('users.index');
                // 用户详情
                Route::get('users/{user}', 'UsersController@show')->name('users.show');*/

                //<------ route api↑
            });
    });
