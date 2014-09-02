<?php
/**
 * Created by PhpStorm.
 * User: itcoder
 * Date: 01.09.14
 * Time: 21:56
 */
class Html{
    public static function encode($text)
    {
        return htmlspecialchars($text,ENT_QUOTES);
    }

    public static function addslash($data = [])
    {
        $dataList = [];
        if (is_array($data))
            foreach ($data as $key => $value){
                $dataList[$key] = addslashes($value);
            }
        return $dataList;
    }
}
