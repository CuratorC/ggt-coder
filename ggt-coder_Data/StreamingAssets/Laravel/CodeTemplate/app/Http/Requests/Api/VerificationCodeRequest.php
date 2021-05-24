<?php

namespace App\Http\Requests\Api;

class VerificationCodeRequest extends FormRequest
{
  public function rules()
  {
    return [
      'linkman_phone' => [
        'required',
        'phone:CN,mobile',
        'unique:users'
      ]
    ];
  }


  public function messages(): array
  {
    return [
      'linkman_phone.phone' => '联系人手机号格式错误',
    ];
  }
}
