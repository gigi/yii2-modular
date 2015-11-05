<?php

use yii\bootstrap\Html;

/**
 * Global DI container configure
 *
 * e.g.
 * \Yii::$container->set('yii\widgets\LinkPager', ['maxButtonCount' => 5]);
 *
 * more here
 * http://www.yiiframework.com/doc-2.0/guide-concept-di-container.html
 * http://martinfowler.com/articles/injection.html
 */

// GridView
\Yii::$container->set('common\widgets\Grid', [
    'layout' => '{items}{summary}{pager}',
    'options' => ['class' => 'page__content'],
    'tableOptions' => ['class' => 'table table-striped'],
    'summaryOptions' => ['class' => 'table-summary'],
    'captionOptions' => ['class' => 'table-caption page__content-title']
]);

// Grid action buttons
\Yii::$container->set('yii\grid\ActionColumn', [
    'template' => '{edit} {delete}',
    'buttons' => [
        'edit' => function ($url, $model, $key) {
            return Html::a('<span class="icon icon-pencil2"></span>', $url, [
                'class' => 'table-action-button transition-bg btn btn-xs btn-default',
            ]);
        },
        'delete' => function ($url, $model, $key) {
            return Html::a('<span class="icon icon-bin"></span>', $url, [
                'class' => 'table-action-button transition-bg btn btn-xs btn-default',
                'data-confirm' => Yii::t('yii', 'Are you sure?'),
            ]);
        }
    ]
]);