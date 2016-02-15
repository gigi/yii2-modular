<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace modules\users\components;

use common\components\BackendController;
use yii\data\ActiveDataProvider;

class ModuleController extends BackendController
{
    /**
     * Returns Active data provider for grid
     * @param \yii\db\ActiveQuery $query
     * @return ActiveDataProvider
     */
    public function getActiveDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->getParams('pageSize'),
            ]
        ]);
    }
}