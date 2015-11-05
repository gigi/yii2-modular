<?php

namespace common\exceptions;

use yii\base\InvalidParamException;

class UserNotFoundException extends InvalidParamException
{
    public function __construct($message = 'User not found', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}