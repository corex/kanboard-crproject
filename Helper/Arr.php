<?php

namespace Kanboard\Plugin\CRProject\Helper;

class Arr
{
    /**
     * Get.
     *
     * @param mixed $data
     * @param string $key
     * @param mixed $defaultValue Default null.
     * @return mixed
     */
    public static function get($data, $key, $defaultValue = null)
    {
        if (!is_array($data)) {
            return $defaultValue;
        }
        if (self::has($data, $key)) {
            return $data[$key];
        }
        return $defaultValue;
    }

    /**
     * Get int.
     *
     * @param mixed $data
     * @param string $key
     * @param integer $defaultValue Default 0.
     * @return integer
     */
    public static function getInt($data, $key, $defaultValue = 0)
    {
        return intval(self::get($data, $key, $defaultValue));
    }

    /**
     * Get bool.
     *
     * @param mixed $data
     * @param string $key
     * @param boolean $defaultValue Default false.
     * @return boolean
     */
    public static function getBool($data, $key, $defaultValue = false)
    {
        $value = self::get($data, $key, $defaultValue);
        return in_array($value, array(true, 1, 'true', 'yes', 'on'));
    }

    /**
     * Has.
     *
     * @param mixed $data
     * @param string $key
     * @return boolean
     */
    public static function has($data, $key)
    {
        if (!is_array($data)) {
            return false;
        }
        return array_key_exists($key, $data);
    }

    /**
     * Remove.
     *
     * @param mixed &$data
     * @param string $key
     * @return mixed
     */
    public static function remove(&$data, $key)
    {
        if (!is_array($data)) {
            return $data;
        }
        if (self::has($data, $key)) {
            unset($data[$key]);
        }
    }

    /**
     * To key.
     *
     * @param array $items
     * @param $keyField
     * @param string $valueField Default null.
     * @return array
     */
    public static function toKey(array $items, $keyField, $valueField = null)
    {
        $result = array();
        if (count($items) == 0 || empty($items[0][$keyField])) {
            return $result;
        }
        if ($valueField !== null && !array_key_exists($valueField, $items[0])) {
            return $result;
        }
        foreach ($items as $item) {
            $key = $item[$keyField];
            $value = $item;
            if ($valueField !== null) {
                $value = $item[$valueField];
            }
            $result[$key] = $value;
        }
        return $result;
    }
}