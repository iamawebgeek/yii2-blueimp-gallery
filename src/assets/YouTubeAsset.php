<?php

namespace iamwebdesigner\blueimp\assets;

class YouTubeAsset extends BlueImpAsset
{
    public $js = ['js/blueimp-gallery-youtube.js'];
    public $css = [];
    public $depends = ['iamwebdesigner\blueimp\assets\VideoAsset'];
}