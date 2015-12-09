<?php

namespace common\base;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}