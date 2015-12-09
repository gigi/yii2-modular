<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use \common\widgets\Grid;

$this->title = 'Roles and permissions';

?>
<div class="container-fluid">
    <div class="row row-no-padding">
        <div class="col-md-6"><?= Grid::widget([
                'caption' => 'Roles',
                'dataProvider' => $rolesDataProvider,
                'columns' => [
                    'name',
                    'description',
                    ['class' => 'yii\grid\ActionColumn']
                ],
            ]); ?></div>
        <div class="col-md-6"><?= Grid::widget([
                'caption' => 'Permissions',
                'dataProvider' => $permissionsDataProvider,
                'columns' => [
                    'name',
                    'description',
                    ['class' => 'yii\grid\ActionColumn']
                ],
            ]); ?></div>
    </div>
</div>
