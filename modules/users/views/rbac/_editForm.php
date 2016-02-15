<?php

use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

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
<?= $form->field($model, 'ruleClass')->hint('Full class namespace') ?>
<?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

<?php if (!empty($children)) : ?>
    <fieldset>
        <legend>Children</legend>
        <?php //= $form->field($model, 'children')->label($groupLabel)->checkboxList($data) ?>
        <?php foreach($children as $groupLabel => $data) : ?>
            <div class="form-group field-roles-children <?=$model->hasErrors('children') ? 'has-error' : ''?>">
                <label class="control-label col-sm-2" for="roles-children"><?=$groupLabel?></label>
                <div class="col-sm-5">
                    <div id="roles-children">
                        <?=Html::checkboxList(\common\components\Helper::getBaseClassName($model) . '[children]', $model->children, $data, [
                            'encode' => false,
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $checkbox = Html::checkbox($name, $checked, [
                                    'value' => $value,
                                    'label' => $label
                                ]);
                                return Html::tag('div', $checkbox, ['class' => 'checkbox']);
                            }
                        ]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <div class="col-sm-offset-2 col-sm-5 has-error">
            <div class="help-block">
                <?php foreach($model->getErrors('children') as $error) : ?>
                    <?=$error?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </fieldset>

    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
