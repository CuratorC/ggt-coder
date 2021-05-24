<?php

namespace App\Models\Traits;

use DB;
use Log;

trait MiddleTableOperate
{

  /**
   * 当传递 array 时，格式为： ['field' => 'storage_image', 'id' => 12];
   */
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
    if (is_array($secondModel)) { // 数组键值对
      $this->insertMiddleTableData($query, $first_key, $firstModel->id, $second_key, $secondModel['id']);
    } elseif (object_is_collection($secondModel)) {
      foreach ($secondModel as $item) { // 集合
        $this->insertMiddleTableData($query, $first_key, $firstModel->id, $second_key, $item->id);
      }
    } else { // 模型
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
      // 判断前半部分完全匹配的话，调转排序 - laravel 的排序特性
      $lengthOne = strlen($modelArray[0]);
      $lengthTwo = strlen($modelArray[1]);
      if ($lengthTwo > $lengthOne) {
        $substr = substr($modelArray[1], 0, $lengthOne);
        if ($substr === $modelArray[0]) {
          $temp = $modelArray[0];
          $modelArray[0] = $modelArray[1];
          $modelArray[1] = $temp;
        }
      }

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
    if (is_array($model)) return $model['field'];
    else if (object_is_collection($model)) return $this->getModelName($model[0]);
    else return str_replace('\\', '', str_replace('App\Models\\', '', get_class($model)));
  }
}
