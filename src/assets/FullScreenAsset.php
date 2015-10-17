<?php

namespace iamwebdesigner\blueimp\assets;

class FullScreenAsset extends BlueImpAsset
{
    public $js = ['js/blueimp-gallery-fullscreen.js'];
    public $css = [];
    public $depends = ['iamwebdesigner\blueimp\assets\BlueImpAsset'];
}