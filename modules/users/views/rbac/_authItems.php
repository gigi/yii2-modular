<?php

use \common\widgets\Grid;
use yii\helpers\Html;

?>

<?php \yii\widgets\Pjax::begin(); ?><div class="page__content"><?= Grid::widget([
    'caption' => $title,
    'headerButtons' => [
        'create' => ['rbac/create-' . $modelId]
    ],
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'description',
        'createdAt:datetime',
        [
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) use ($modelId) {
                    $url = ['rbac/edit-' .  $modelId, 'id' => $model->getName()];

                    return Html::a('<span class="icon icon-pencil2"></span>', $url, [
                        'class' => 'table-action-button transition-bg btn btn-xs btn-default',
                    ]);
                },
                'delete' => function ($url, $model, $key) use ($modelId) {
                    $url = ['rbac/delete-' .  $modelId, 'id' => $model->getName()];

                    return Html::a('<span class="icon icon-bin"></span>', $url, [
                        'class' => 'table-action-button transition-bg btn btn-xs btn-default',
                        'data-confirm' => Yii::t('yii', 'Are you sure?'),
                    ]);
                }
            ],
            'class' => 'yii\grid\ActionColumn'
        ]
    ],
]); ?></div><?php \yii\widgets\Pjax::end(); ?>