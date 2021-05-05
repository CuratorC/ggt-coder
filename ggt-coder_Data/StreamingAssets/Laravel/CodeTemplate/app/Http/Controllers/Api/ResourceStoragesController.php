<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ResourceStorageRequest;
use App\Models\ResourceStorage;
use Storage;

class ResourceStoragesController extends Controller
{

    public function coverSign(ResourceStorageRequest $request, ResourceStorage $resourceStorage)
    {
        // 文件名称
        // 生成文件名称
        $responseStorage = $resourceStorage->new($request->path);

        // 生成签名信息
        $disk = Storage::disk('oss');

        $config = $disk->signatureConfig($prefix = $request->path . '/', $callBackUrl = '', $customData = [], $expire = 30);
        return responseSuccess('查询成功', array_merge(
            json_decode($config, true), [
            'resource_storage_id' => $responseStorage->id,
            'resource_storage_name' => $responseStorage->name,
        ]));
    }
}
