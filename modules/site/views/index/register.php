<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['action' => ['/register']]); ?>
            <?= $form->field($model, 'email') ?>
            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>