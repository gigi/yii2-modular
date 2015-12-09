<?php

/*
 * This file is part of the Yii2-modular skeleton https://github.com/gigi/yii2-modular
 *
 * (c) Alexey Snigirev <http://github.com/gigi>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

$this->title = $model->getAttributeLabel('type');

?>

<div class="page__content">
    <div class="page__content-title"><?=$model->name?></div>
    <div class="page__content-inner">
        <?=$this->render('_editForm', ['model' => $model])?>
    </div>
</div>


