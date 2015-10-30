<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Edit user';

?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'email') ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'confirm-button']) ?>
    </div>
<?php ActiveForm::end(); ?>