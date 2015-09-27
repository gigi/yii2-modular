<?php

namespace common\bundles;

use yii\web\AssetBundle;

class NormalizeAsset extends AssetBundle
{
    public $sourcePath = '@common/assets';
    public $css = [
        'css/normalize.css'
    ];
}
