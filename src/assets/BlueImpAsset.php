<?php

namespace iamwebdesigner\blueimp\assets;

use yii\web\AssetBundle;

/**
 * Class BlueImpAsset
 * @author iamwebdesigner
 */
class BlueImpAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-gallery';
    public $js = [
        'js/blueimp-helper.js',
        'js/blueimp-gallery.js',
        'js/jquery.blueimp-gallery.js'
    ];
    public $css = [
        'css/blueimp-gallery.min.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset'
    ];
}