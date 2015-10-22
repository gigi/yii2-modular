<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="site-confirm">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['action' => ['/confirm', 'token' => $model->token]]); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'passwordConfirm')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'confirm-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>