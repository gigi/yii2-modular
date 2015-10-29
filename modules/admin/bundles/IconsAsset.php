<?php

namespace modules\admin\bundles;

/**
 * Class SiteAsset
 * Main asset bundle for modules
 */
class IconsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@modules/admin/assets';
    public $css = [
        'icons/icons.css'
    ];
}