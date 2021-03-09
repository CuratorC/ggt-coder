<?php

namespace App\Models;

use App\Models\Traits\MiddleTableOperate;
use App\Models\Traits\ScopeCoderSearch;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Model extends EloquentModel
{
    use HasFactory;
    use SoftDeletes; // 软删除
    use ScopeCoderSearch; // scope 查询
    use MiddleTableOperate; // 中间表操作
}

