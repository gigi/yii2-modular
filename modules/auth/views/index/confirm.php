<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Confirm email';

?>

<div class="site-confirm">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['action' => ['', 'token' => $model->token]]); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'passwordConfirm')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'confirm-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>