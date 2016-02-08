<?php

use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use common\components\Helper;

$this->title = 'Edit user';

?>

<div class="page__content">
    <div class="page__content-title">General</div>
    <div class="page__content-inner">
        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'fullSpan' => 7,
            'formConfig' => [
                'labelSpan' => 2,
                'deviceSize' => ActiveForm::SIZE_SMALL,
            ]
        ]); ?>
        <?= $form->field($model, 'created')->staticInput() ?>
        <?= $form->field($model, 'status')->label()->radioButtonGroup(Helper::array_column($statuses,
            'label', true),
            [
                'class' => 'btn-group-sm',
                    'itemOptions' => [
                        'labelOptions' => [
                            'class' => 'btn btn-success'
                        ]
                    ]
            ]
        ) ?>
        <?= $form->field($model, 'email') ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="page__content">
    <div class="page__content-title">New password</div>
    <div class="page__content-inner">
        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'fullSpan' => 7,
            'formConfig' => [
                'labelSpan' => 2,
                'deviceSize' => ActiveForm::SIZE_SMALL,
            ]
        ]); ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
