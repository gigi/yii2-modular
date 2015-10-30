<?php

use yii\helpers\Url;

\common\bundles\BootstrapAsset::register($this);
\modules\admin\bundles\AdminAsset::register($this);
\modules\admin\bundles\IconsAsset::register($this);

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
            <ul class="nav-list">
                <li class="nav-list__item">
                    <a class="nav-list__link" href="<?= Url::to(['users/index']);?>">
                        <i class="nav-list__item-icon icon icon-users"></i>
                        <span class="nav-list__item-title">Users</span>
                    </a>
                </li>
                <li class="nav-list__item">
                    <a class="nav-list__link" href="#">
                        <i class="nav-list__item-icon icon icon-mail4"></i>
                        <span class="nav-list__item-title">Emails</span>
                    </a>
                </li>
                <li class="nav-list__item">
                    <a class="nav-list__link" href="#">
                        <i class="nav-list__item-icon icon icon-books"></i>
                        <span class="nav-list__item-title">Logs</span>
                    </a>
                </li>
            </ul>
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
            <div class="page__content">
                <?= $content ?>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>