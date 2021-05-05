<?php
namespace App\Models\Traits;

use DB;
use Illuminate\Database\Query\Builder;

trait MiddleTableOperate
{

    public function middleSync($object)
    {
        [$table_name, $first_key, $second_key] = $this->getMiddleTableName($object);

        if ($table_name) {
            $query = DB::table($table_name);
            // 当第一模型为集合时，遍历第一模型
            if (object_is_collection($this)) {
                foreach ($this as $item) {
                    $this->insertForeachSecondModel($item, $object, $query, $first_key, $second_key);
                }
            } else {
                $this->insertForeachSecondModel($this, $object, $query, $first_key, $second_key);
            }
        }
    }

    /**
     * @description 为第二模型插入数据
     * @param $firstModel
     * @param $secondModel
     * @param $query
     * @param $first_key
     * @param $second_key
     * @author CuratorC
     * @date 2021/3/4
     */
    private function insertForeachSecondModel($firstModel, $secondModel, $query, $first_key, $second_key)
    {
        if (object_is_collection($secondModel)) {
            foreach ($secondModel as $item) {
                $this->insertMiddleTableData($query, $first_key, $firstModel->id, $second_key, $item->id);
            }
        } else {
            $this->insertMiddleTableData($query, $first_key, $firstModel->id, $second_key, $secondModel->id);
        }
    }

    /**
     * @description 输入中间表数据
     * @param $query
     * @param $first_key
     * @param $first_value
     * @param $second_key
     * @param $second_value
     * @author CuratorC
     * @date 2021/3/4
     */
    private function insertMiddleTableData($query, $first_key, $first_value, $second_key, $second_value)
    {
        $query->insert([$first_key => $first_value, $second_key => $second_value]);
    }


    /**
     * @description 获取中间表名称
     * @param $object
     * @return array
     * @author CuratorC
     * @date 2021/3/4
     */
    private function getMiddleTableName($object): array
    {
        $firstModelName = create_under_score($this->getModelName($this));
        $secondModelName = create_under_score($this->getModelName($object));
        if ($firstModelName && $secondModelName) {
            $modelArray = [$firstModelName, $secondModelName];
            sort($modelArray);
            return [$modelArray[0] . '_' . $modelArray[1], $firstModelName . '_id', $secondModelName . '_id'];
        } else {
            return [false, false, false];
        }

    }

    /**
     * @description 获取对象的模块名称
     * @param $model
     * @return string
     * @author CuratorC
     * @date 2021/3/4
     */
    private function getModelName($model): string
    {
        if (object_is_collection($model)) return $this->getModelName($model[0]);
        else return $model_name = str_replace('\\', '', str_replace('App\Models\\', '', get_class($model)));
    }

}
