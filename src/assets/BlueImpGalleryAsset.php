<?php

namespace iamwebdesigner\blueimp\assets;

use yii\web\AssetBundle;

class BlueImpGalleryAsset extends AssetBundle
{
    public $sourcePath = __DIR__;
    public $js = ['js/jquery.blueimp.js'];
    public $depends = ['iamwebdesigner\blueimp\assets\BlueImpAsset'];
}