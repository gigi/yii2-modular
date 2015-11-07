<?php

namespace common\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class BackendAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@common/assets/backend';
    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:400,500,300,700&subset=latin,cyrillic',
        'css/style.css'
    ];
}