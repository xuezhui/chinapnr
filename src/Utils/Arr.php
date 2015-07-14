<?php

namespace Fakeronline\Chinapnr\Utils;

class Arr{

    /**
     * 获取数组的值 -- 可深度获取
     * $array = ['names' => ['joe' => ['programmer']]];
     * $value = array_get($array, 'names.joe');
     * @param $array
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }

    public static function getAll(array $array, array $key_array, $filterNull = false){

        $result = [];

        foreach($key_array as $key){

            $temp = self::get($array, $key);

            if(is_null($temp) && $filterNull){
                continue;
            }

            $result[$key] = $temp;

        }

        return $result;

    }

}