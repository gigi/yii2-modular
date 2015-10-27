<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';

?>

<div class="site-register">
    <div class="row">
        <div class="col-lg-5">
            <?php if (isset($needConfirmation)) : ?>
                <p>Confirm message was sent to email: <?= $model->email ?></p>
            <?php else: ?>
                <?php $form = ActiveForm::begin(['action' => ['/register']]); ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>