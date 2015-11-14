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
Common layout start
    <?= $content ?>
Common layout end
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>