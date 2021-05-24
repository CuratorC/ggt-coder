<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Auth;

abstract class TestCase extends BaseTestCase
{
  // 数据库自动回滚
  use RefreshDatabase;
  use CreatesApplication;

  // 初始化方法
  protected function setUp(): void
  {
    parent::setUp();
    $this->withoutExceptionHandling()->withHeaders(['accept' => 'application/json']);

    TestResponse::macro('data', function ($key) {
      // 通过 $this->original->getData() 可以获取绑定到视图的原始数据
      return $this->original->getData()[$key];
    });
  }

  /**
   * @description 用户登入
   * @param null $user
   * @return $this
   * @author CuratorC
   * @date 2021/2/5
   */
  protected function signIn($user = null): TestCase
  {
    $user = $user ?: create(User::class);

    Auth::login($user);
    $token = Auth::guard('api')->login($user);
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    return $this;
  }
}
