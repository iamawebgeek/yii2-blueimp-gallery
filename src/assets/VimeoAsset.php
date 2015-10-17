<?php

namespace iamwebdesigner\blueimp\assets;

class VimeoAsset extends BlueImpAsset
{
    public $js = ['js/blueimp-gallery-vimeo.js'];
    public $css = [];
    public $depends = ['iamwebdesigner\blueimp\assets\VideoAsset'];
}