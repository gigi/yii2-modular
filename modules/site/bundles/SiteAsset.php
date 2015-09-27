<?php

namespace modules\site\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class SiteAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@modules/site/assets';
    public $css = [
        'css/style.css'
    ];

}