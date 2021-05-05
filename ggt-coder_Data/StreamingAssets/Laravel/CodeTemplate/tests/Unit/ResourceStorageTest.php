<?php

namespace Tests\Unit;

use App\Models\ResourceStorage;
use Tests\TestCase;

class ResourceStorageTest extends TestCase
{

    /**
     * @test
     * @description 可以获取资源
     * @author CuratorC
     * @date 2021/3/10
     */
    public function guest_can_get_resource_storage()
    {
        $resourceStorage = new ResourceStorage();
        $storage = $resourceStorage->new('upload/images');
        $this->assertDatabaseHas('resource_storages', ['name'   => $storage->name]);
    }

    /**
     * @test
     * @description 资源可以被删除
     * @author CuratorC
     * @date 2021/3/10
     */
    public function resource_storage_can_be_delete()
    {
        $resourceStorage = new ResourceStorage();
        $storage = $resourceStorage->new('upload/images');
        $storage->forceDeleteStorage();
        $this->assertDatabaseMissing('resource_storages', ['name'   => $storage->name]);
    }
}

