<?php

namespace iamwebdesigner\blueimp\assets;

class VideoAsset extends BlueImpAsset
{
    public $js = ['js/blueimp-gallery-video.js'];
    public $css = ['css/blueimp-gallery-video.css'];
    public $depends = ['iamwebdesigner\blueimp\assets\BlueImpAsset'];
}