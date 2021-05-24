<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use Hash;
use Illuminate\Auth\AuthenticationException;

class UsersController extends Controller
{
  public function store(UserRequest $request)
  {
    $verifyData = \Cache::get($request->verification_key);

    if (!$verifyData) {
      abort(403, '验证码已失效');
    }

    if (!hash_equals($verifyData['code'], $request->verification_code)) {
      // 返回401
      throw new AuthenticationException('验证码错误');
    }

    $user = User::create([
      'name' => $request->name,
      'password' => Hash::make($request->password),
      'company_name' => $request->company_name,
      'linkman_name' => $request->linkman_name,
      'linkman_phone' => $verifyData['phone'],
    ]);

    // 清除验证码缓存
    \Cache::forget($request->verification_key);

    return new UserResource(User::find($user->id));
  }
}
