<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

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
            <h5 class="info__title">Gigi@ua.fm</h5>
            <div class="info__content">
                Welcome to backend!
            </div>
        </div>
        <nav class="nav">
            <ul class="nav-list">
                <li class="nav-list__item">
                    <a class="nav-list__link" href="#">
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
            <ul class="breadcrumbs">
                <li class="breadcrumb__item"><a class="breadcrumb__item-link" href="/">Home</a></li>
                <li class="breadcrumb__item"><a class="breadcrumb__item-link" href="users">Users</a></li>
            </ul>
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