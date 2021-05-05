<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    // 数据库自动回滚
    use RefreshDatabase;
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        TestResponse::macro('data', function($key) {
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

        $this->actingAs($user);

        return $this;
    }
}
