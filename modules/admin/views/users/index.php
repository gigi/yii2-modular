<?php

use \common\widgets\Grid;
use \yii\bootstrap\Html;

$this->title = 'Users';

?>

<?= Grid::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'email',
        'created:datetime',
        'updated:datetime',
        [
            'label' => 'Status',
            'format' => 'raw',
            'value' => function($row) use ($model) {
                $status = $model::getStatuses($row->status);

                return Html::label($status['label'], null, ['class' => 'label label-' . $status['type']]);
            }
        ],
        ['class' => 'yii\grid\ActionColumn']
    ],
]); ?>