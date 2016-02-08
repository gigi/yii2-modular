<?php

use common\widgets\Menu;

\common\bundles\BootstrapAsset::register($this);
\common\bundles\BackendAsset::register($this);
\common\bundles\IconsAsset::register($this);

?>

<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <?= \yii\helpers\Html::csrfMetaTags() ?>
        <title><?= $this->title ?></title>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <header class="header">
        <a href="/" class="header-title"><?= \Yii::$app->name ?></a>

        <div class="header-info">
            <?= \yii\bootstrap\ButtonDropdown::widget([
                'label' => '<i class="icon icon-users"></i> ' . $this->context->getUser()['email'],
                'encodeLabel' => false,
                'split' => true,
                'options' => [
                    'class' => 'btn-default'
                ],
                'dropdown' => [
                    'options' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label' => '<i class="icon icon-cogs"></i> Edit',
                            'url' => ['/users/index/edit', 'id' => $this->context->getUser()['id']]
                        ],
                        [
                            'label' => '<i class="icon icon-exit"></i> Logout',
                            'url' => ['/auth/index/logout']
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </header>

    <aside class="side-content">
        <div class="info">
            <h5 class="info__title"><?= $this->context->getUser()['email'] ?></h5>

            <div class="info__content">
                Welcome to backend!
            </div>
        </div>
        <nav class="nav">
            <?= Menu::widget([
                'encodeLabels' => false,
                'activeCssClass' => 'nav-list__item_active',
                'activateParents' => true,
                'items' => Yii::$app->menu->get('admin'),
                'options' => [
                    'class' => 'nav-list'
                ],
                'itemOptions' => [
                    'class' => 'nav-list__item'
                ],
                'submenuTemplate' => '<ul class="nav-list">{items}</ul>',
                'linkTemplate' => '<a class="nav-list__link" href="{url}">{label}</a>'
            ]) ?>
        </nav>
    </aside>

    <div class="page">
        <div class="page__head">
            <h1 class="page__title"><?= $this->title ?></h1>
            <?= \yii\widgets\Breadcrumbs::widget([
                'itemTemplate' => '<li class="breadcrumbs__item">{link}</li>',
                'activeItemTemplate' => '<li class="breadcrumbs__item breadcrumbs__item_active">{link}</li>',
                'options' => [
                    'class' => 'breadcrumbs'
                ],
                'homeLink' => [
                    'label' => 'Home',
                    'url' => '/admin',
                    'class' => 'breadcrumbs__item-link'
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div class="page__content-wrapper">
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>