<?php

use \common\widgets\Grid;
use \yii\bootstrap\Html;

$this->title = 'Users';

?>
<div class="page__content">
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
            'value' => function($row) use ($getStatus) {
                $status = $getStatus($row->status);

                return Html::label($status['label'], null, ['class' => 'label label-' . $status['type']]);
            }
        ],
        ['class' => 'yii\grid\ActionColumn']
    ],
]); ?></div>

<div class="page__content">
    <div class="page__content-title">Title</div>
    <div class="page__content-inner">Hello from content</div>
</div>
