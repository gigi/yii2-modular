<?php

use yii\widgets\Menu;

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
        <a href="/" class="header-title">Yii2-Modular</a>
    </header>

    <aside class="side-content">
        <div class="info">
            <h5 class="info__title">user@example.com</h5>
            <div class="info__content">
                Welcome to backend!
            </div>
        </div>
        <nav class="nav">
        <?=Menu::widget([
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
        ])?>
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