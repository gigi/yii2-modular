<?php

use kartik\form\ActiveForm;
use yii\bootstrap\Html;

?>

<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fullSpan' => 7,
    'formConfig' => [
        'labelSpan' => 2,
        'deviceSize' => ActiveForm::SIZE_SMALL,
    ]
]); ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
