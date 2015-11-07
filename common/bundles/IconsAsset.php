<?php

namespace common\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class IconsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/assets/icons';
    public $css = [
        'icons.css'
    ];
}