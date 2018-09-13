<?php
/**
 * 常用工具类
 */
namespace app\classes;

class Util{

    // 校验日期格式XXXX-XX-XX
    public static function checkDate($date) {
        $newDate = date('Y-m-d', strtotime($date));
        if ($date == $newDate) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * 返回字符串的毫秒数时间戳
     * @return array|string
     */
    public static function get_total_millisecond()
    {
        $time = time();
        return str_pad($time, 13, 0);
    }
} 
