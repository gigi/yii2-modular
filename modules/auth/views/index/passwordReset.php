<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';

?>

<div class="site-forgotten">
    <div class="row">
        <div class="col-lg-5">
            <?php if (!empty($reset)) : ?>
                <p>Check your email for further instructions.</p>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'forgotten-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>