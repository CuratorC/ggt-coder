<?php

/**
 * 生成随机字符串
 * @param int $length 长度
 * @return string 字符串
 */
function get_str_random($length = 6): string
{
    return get_random($length, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * @description 产生随机字符串
 * @param int $length
 * @param string $chars
 * @return string
 * @author CuratorC
 * @date 2021/2/26
 */
function get_random(int $length, $chars = '0123456789'): string
{
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * @description 格式化金额
 * @param $obj
 * @return string
 * @author CuratorC
 * @date 2021/2/26
 */
function format_money($obj): string
{
    return number_format($obj, 2);
}

/**
 * @description 格式化数字
 * @param $decimal
 * @return float
 * @author CuratorC
 * @date 2021/2/26
 */
function format_decimal($decimal): float
{
        return round($decimal,2);
}

/**
 * @description 格式化显示手机
 * @param $phone
 * @return string
 * @author CuratorC
 * @date 2021/2/26
 */
function format_show_phone($phone): string
{
    if (strlen($phone) == 11) {
        return substr($phone, 0, 3) . ' ' . substr($phone, 3, 4) . ' ' . substr($phone, 7);
    } else {
        return $phone;
    }
}

/**
 * @description 格式化隐藏手机
 * @param $phone
 * @return string
 * @author CuratorC
 * @date 2021/2/26
 */
function format_hidden_phone($phone): string
{
    if (strlen($phone) == 11) {
        return substr($phone, 0, 3) . ' **** ' . substr($phone, 7);
    } else {
        return substr($phone, 0, 3) . '???';
    }
}

/**
 * @description 金额去逗号
 * @param $string
 * @return array|float
 * @author CuratorC
 * @date 2021/2/26
 */
function replace_money($string)
{
    if (is_array($string) || is_object($string)) {
        $return = array();
        foreach ($string as $item) {
            $return[] = (float)str_replace(',', '', $item);
        }
        return $return;
    }else return (float)str_replace(',', '', $string);
}

/**
 * @description YYYY-MM-dd HH:ii:ss 转 YYYY/MM/dd
 * @param $string
 * @return false|mixed|string|string[]
 * @author CuratorC
 * @date 2021/2/26
 */
function datetime_to_date($string)
{
    $result = explode(' ', $string);
    if (is_array($result)) return $result[0];
    else return $result;
}
/**
 * @description 将多维数组转换为一维数组
 * @param $arr
 * @param array $return
 * @return array
 * @author CuratorC
 * @date 2021/2/5
 */
function array_to_dimension($arr, $return = []): array
{
    if (is_dimensions($arr)) {
        // 是多维数组，对其中每一位都调用变换
        foreach ($arr as $item) {
            $return = array_to_dimension($item, $return);
        }
    } else {
        // 不是多维，将 arr 并入 return ,返回 return
        $return = array_merge($return, $arr);

    }
    return $return;
}

/**
 * @description 是否为多维数组
 * @param $arr
 * @return bool
 * @author CuratorC
 * @date 2021/2/5
 */
function is_dimensions($arr): bool
{
    return !(count($arr) == count($arr, 1));
}

/**
 * @description 驼峰转下划线
 * @param $camelCaps
 * @param string $separator
 * @return string
 * @author CuratorC
 * @date 2021/3/4
 */
function create_under_score($camelCaps,$separator='_'): string
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
}
/**
 * @description 对象是否为集合
 * @param $object
 * @return bool
 * @author CuratorC
 * @date 2021/3/4
 */
function object_is_collection($object): bool
{
    return get_class($object) == \Illuminate\Database\Eloquent\Collection::class;
}


/**
 * @description 返回成功信息
 * @param string $message
 * @param array $data
 * @param int $status
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
 * @author CuratorC
 * @date 2021/3/9
 */
function response_success($message = '操作成功', $data = [], $status = 200)
{
    return response(array_filter([
        'message'   => $message,
        'data'      => $data,
    ]), $status);
}
