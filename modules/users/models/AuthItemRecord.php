<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\models;

use common\base\ActiveRecord;

/**
 * Auth item Active record model
 *
 * @author Alexey Snigirev <gigi@ua.fm>
 */
class AuthItemRecord extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_item';
    }
}
