<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
  public function rules()
  {
    switch (request()->route()->getActionMethod()) {
      case 'store':
        return [
          'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
          'password' => 'required|alpha_dash|min:6',
          'company_name' => 'required|string',
          'linkman_name' => 'required|string',
          'verification_key' => 'required|string',
          'verification_code' => 'required|string',
        ];
      default:
        return [];
    }
  }

  public function attributes()
  {
    return [
      'name' => '账号',
      'password' => '密码',
      'company_name' => '单位名称',
      'linkman_name' => '联系人姓名',
      'linkman_phone' => '联系人手机号',
      'verification_key' => '短信验证码 key',
      'verification_key' => '短信验证码',
    ];
  }
}
