<?php
namespace App\Models\Traits;

use App\Models\ResourceStorage;
use Storage;

trait StorageManage
{

    /**
     * @description 删除资源
     * @param $field
     * @author CuratorC
     * @date 2021/3/10
     */
    public function deleteStorage($field)
    {
        $storage = ResourceStorage::find($this->$field);
        // 删除掉 oss 中的资源来节省空间
        // $disk = Storage::disk('oss');
        // $disk->delete($storage->name);
        $storage->delete();
    }

    /**
     * @description 标记使用
     * @param $field
     * @author CuratorC
     * @date 2021/3/10
     */
    public function usedStorage($field)
    {
        $storage = ResourceStorage::find($this->$field);
        $storage->used = ResourceStorage::USED_TRUE_CODE;
        $storage->used_model_type = get_class($this);
        $storage->used_model_id = $this->id;
        $storage->used_model_field = $field;
        $storage->save();
    }
}
