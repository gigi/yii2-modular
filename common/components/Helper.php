<?php

namespace common\components;

use yii\helpers\Inflector;

/**
 * Set of string, array helpers
 * Extends yii\helpers\Inflector class
 */
class Helper extends Inflector
{
    /**
     * Extended Array_column implementation for PHP < 5.5
     * http://php.net/manual/en/function.array-column.php
     * @param array $array Input array
     * @param string $columnName
     * @param mixed $indexKey If string value then use the corresponding array key, if true preserve keys
     * @return array
     */
    public static function array_column(array $array, $columnName, $indexKey = null)
    {
        if (function_exists("array_column") && $indexKey !== true) {
           return array_column($array, $columnName, $indexKey);
        }

        $result = [];
        array_walk($array,
            function(&$item, $key) use ($columnName, $indexKey, &$result) {
                if ($indexKey === true) {
                    $result[$key] = $columnName ? $item[$columnName] : $item;
                } elseif ($columnName !== null && $indexKey) {
                    $result[$item[$indexKey]] = $item[$columnName];
                } elseif ($columnName !== null) {
                    $result[] = $item[$columnName];
                } elseif ($columnName === null && $indexKey) {
                    $result[$item[$indexKey]] = $item;
                } else {
                    $result[] = $item;
                }
            }
        );

        return $result;
    }
}