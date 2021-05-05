<?php

namespace Tests\Feature\ResourceStorages;

use App\Models\Conference;
use App\Models\InviteLink;
use Tests\TestCase;

class GetResourceStoragesTest extends TestCase
{

    /**
     * @test
     * @description
     * @author CuratorC
     * @date 2021/3/9
     */
    public function guest_can_get_resource_storage()
    {
        $this->getWithoutLogin(route('api.v1.resource_storage.cover_sign', ['path'  => get_str_random(6)]))
            ->assertStatus(200);
    }
}
