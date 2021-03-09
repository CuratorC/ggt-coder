<?php
namespace App\Models\Traits;

use Carbon\Carbon;

trait ScopeCoderSearch
{

    protected $searchRequest;

    // 查询字段记录
    private $searchArray = array();

    /**
     * @description 单条查询
     * @param $query
     * @param $field
     * @param $func
     * @return mixed
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderWhen($query, $field, $func)
    {
        $query->when($this->searchRequest->$field, function ($query) use ($func, $field) {
            $func($query, $this->searchRequest->$field);
        });
        $searchArray[] = ['field' => $field, 'func' => $func];

        return $query;
    }

    /**
     * @description 为 keyword 匹配所有查询条件查询
     * @param $query
     * @return mixed
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderWhenKeyword($query)
    {
        return $query->when('keyword', function ($query) {
            foreach ($this->searchArray as $search) {
                $func = $search['func'];
                $field = $search['field'];
                $func($query, $this->searchRequest->$field);
            }
        });
    }

    /**
     * @description order 排序
     * @param $query
     * @param mixed ...$orderRules
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderOrder($query, ...$orderRules)
    {
        // 检查用户自带参数
        $query->when($this->searchRequest->field, function ($query) {
            // 补全 order 参数、
            if (empty($this->searchRequest->order)) $this->searchRequest->order = 'ASC';
            $query->orderBy($this->searchRequest->field, $this->searchRequest->order);
        });

        // 循环程序自定义参数
        foreach ($orderRules as $orderRule) {
            if (is_string($orderRule)) $query->orderBy($orderRule);
            if (is_array($orderRule)) $query->orderBy($orderRule[0], $orderRule[1]);
        }

        // 追加固定排序
        $query->orderBy('id', 'DESC');
    }


    /**
     *ㅤ分页
     * @param $query
     * @return mixed
     * @date 2020/10/13
     * @author Curator
     */
    public function scopeCoderPaginate($query)
    {
        if (empty($this->searchRequest->size)) $this->searchRequest->size = 10;
        return $query->paginate($this->searchRequest->size);
    }


    /**
     * @description 日期筛选
     * @param $query
     * @param $field
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderWhereDate($query, $field)
    {
        if (preg_match("/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) - [1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->searchRequest->$field)) {
            $timeArray = explode(' - ', $this->searchRequest->$field);
            // 结束日期加一天
            $endDay = Carbon::create($timeArray[1])->addDay();
            $query->where($field, '>=', $timeArray[0])->where($field, '<=', $endDay);
        }
    }


    /**
     * @description 解析 path 按 id 查找父级
     * @param $query
     * @param $id
     * @param string $field
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderIdInPath($query, $id, $field = 'path')
    {
        $query->where(function ($query) use ($id, $field) {
            $query->where('id', $id)
                ->orWhere($field, 'like', '%-' . $id . '-%')
                ->orWhere($field, 'like', $id . '-%')
                ->orWhere($field, 'like', '%-' . $id)
                ->orWhere($field, $id);
        });
    }

    /**
     * @description 解析 path 按名称查找父级
     * @param $query
     * @param $name
     * @param $modelName
     * @param string $nameField
     * @param string $pathField
     * @author CuratorC
     * @date 2021/3/1
     */
    public function scopeCoderNameInPath($query, $name, $modelName, $nameField = 'name', $pathField = 'path')
    {
        // 先将 name 转换为 model, 然后根据 model->id 使用 scopeCoderIdInPath
        $models = $modelName::where($nameField, 'like', '%' . $name . '%')->get();
        $query->where(function ($query) use ($models, $pathField) {
            foreach ($models as $model) {
                $query->orWhere(function ($query) use ($model, $pathField) {
                    $query->coderIdInPath($model->id, $pathField);
                });
            }
        });
    }

}
