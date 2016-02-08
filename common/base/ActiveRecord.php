<?php

namespace common\base;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param $id
     * @return null|static
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}