<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

\common\bundles\BootstrapAsset::register($this);
\modules\site\bundles\SiteAsset::register($this);

?>

<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <?= \yii\helpers\Html::csrfMetaTags() ?>
        <title><?= $this->title ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body>
    <?php
        NavBar::begin([
            'brandLabel' => 'My Company',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/']],
            ['label' => 'About', 'url' => ['/about']],
            ['label' => 'Contact', 'url' => ['/contact']],
        ];
        if ($this->context->isGuest()) {
            $menuItems[] = ['label' => 'Register', 'url' => ['/register']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/login']];
        } else {
            $menuItems[] = [
                'label' => 'Logout (' . $this->context->getUser()->email . ')',
                'url' => ['/site/index/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    ?>

    <!-- Begin page content -->
    <div class="container">
        <div class="page-header">
            <h1><?= $this->title ?></h1>
        </div>
        <?= $content ?>
    </div>

    <footer class="footer bg-warning">
        <div class="container">
            <p class="text-muted">Footer</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>