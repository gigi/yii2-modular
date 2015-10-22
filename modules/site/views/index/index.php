<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($this->context->isGuest()) : ?>
        Not logged
    <?php else: ?>
        <?= $this->context->getUser()->email ?>
    <?php endif; ?>
</div>