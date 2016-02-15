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

    /**
     * Base class name from full namespace
     * @link http://stackoverflow.com/questions/19901850/how-do-i-get-an-objects-unqualified-short-class-name
     *
     * @param string|object $class
     * @return string
     */
    public static function getBaseClassName($class = null)
    {
        if (empty($class)) {
            $className = get_called_class();
        } else if (is_object($class)) {
            $className = get_class($class);
        } else {
            $className = $class;
        }

        return substr(strrchr($className, '\\'), 1);
    }
}