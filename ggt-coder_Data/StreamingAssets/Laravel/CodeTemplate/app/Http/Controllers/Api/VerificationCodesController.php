<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Str;

class VerificationCodesController extends Controller
{
  public function store(VerificationCodeRequest $request)
  {
    $phone = ltrim(phone($request->linkman_phone, 'CN', 'E164'), '+86');

    // 生成4位随机数，左侧补0
    $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

    try {
      $sms = app('easysms');
      $sms->send($phone, [
        'template' => config('easysms.gateways.aliyun.templates.register'),
        'data' => [
          'code' => $code
        ],
      ]);
    } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
      $message = $exception->getException('aliyun')->getMessage();
      abort(500, $message ?: '短信发送异常');
    }

    $key = 'verificationCode_' . Str::random(15);
    $expiredAt = now()->addMinutes(5);
    // 缓存验证码 5 分钟过期。
    \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

    return response()->json(['data' => [
      'verification_key' => $key,
      'expired_at' => $expiredAt->toDateTimeString(),
    ]])->setStatusCode(201);
  }
}
