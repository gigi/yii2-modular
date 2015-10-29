<?php

namespace modules\admin\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class AdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@modules/admin/assets';
    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:400,500,300,700&subset=latin,cyrillic',
        'css/style.css'
    ];

}