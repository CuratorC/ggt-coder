<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ValidationException;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\Api\AuthorizationRequest;
use Auth;

class AuthorizationsController extends Controller
{
  public function store(AuthorizationRequest $request)
  {
    $credentials = [
      'name'  => $request->name,
      'password'  => $request->password,
    ];

    if (!$token = Auth::guard('api')->attempt($credentials)) {
      throw new ValidationException('用户名或密码错误');
    }

    return $this->respondWithToken($token)->setStatusCode(201);
  }

  public function update()
  {
    $token = auth('api')->refresh();
    return $this->respondWithToken($token);
  }

  public function destroy()
  {
    auth('api')->logout();
    return response(null, 204);
  }

  protected function respondWithToken($token)
  {
    return response()->json(['data' => [
      'access_token' => $token,
      'token_type' => 'Bearer',
      'expires_in' => auth('api')->factory()->getTTL() * 60
    ]])->setStatusCode(201);
  }
}
