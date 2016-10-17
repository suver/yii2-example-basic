<?php

namespace app\modules\users\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/users/assets';
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $css = [
        'css/users.css',
        'css/font-awesome.css',
    ];
    public $js = [
        'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
