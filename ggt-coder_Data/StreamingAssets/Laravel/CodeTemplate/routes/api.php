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
        // 登录
        Route::post('authorizations', [\App\Http\Controllers\Api\AuthorizationsController::class, 'store'])
          ->name('api.authorizations.store');
        // 短信验证码
        Route::post('verification_codes', [VerificationCodesController::class, 'store'])
          ->name('verificationCodes.store');
        // 用户注册
        Route::post('users', [UsersController::class, 'store'])
          ->name('users.store');
        // 获取上传签名
        Route::get('resource_storages/cover_sign', [\App\Http\Controllers\Api\ResourceStoragesController::class, 'coverSign'])->name('resource_storage.cover_sign');
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
