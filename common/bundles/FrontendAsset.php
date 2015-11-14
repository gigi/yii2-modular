<?php

namespace common\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class FrontendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/assets/frontend';
    public $css = [
        'css/style.css'
    ];

}