<?php

namespace App\Models;

use Auth;
use Storage;

class ResourceStorage extends Model
{
    protected $fillable = ['user_id', 'name', 'used', 'used_model_type', 'used_model_id', 'used_model_field'];

    const USED_TRUE_CODE = 1;
    const USED_FALSE_CODE = 9;
    public static function getUsedName(): array
    {
        return [
            self::USED_TRUE_CODE    => '使用中',
            self::USED_FALSE_CODE   => '未使用',
        ];
    }

    /**
     * @description 获取名称
     * @param $path
     * @return mixed
     * @author CuratorC
     * @date 2021/3/10
     */
    public function new($path)
    {
        do {
            $name = $path . '/' . get_str_random(15);
            $occupy = self::where('name', $name)->first();
        } while ($occupy);

        // 创建信息
        return self::create([
            'name'  => $name,
            'user_id'   => Auth::id() ?? 0
        ]);
    }

    /**
     * @description 删除未引用的资源
     * @author CuratorC
     * @date 2021/3/10
     */
    public function forceDeleteStorage(): bool
    {
        if ($this->used == self::USED_TRUE_CODE) return false;
        $disk = Storage::disk('oss');
        // 删除 oss 上面的文件
        if ($disk->has($this->name)) $disk->delete($this->name);
        $this->forceDelete();
        return true;
    }
}
