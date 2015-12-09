<?php

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
            'query' => $query
        ]);
    }
}