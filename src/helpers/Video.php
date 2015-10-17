<?php

namespace iamwebdesigner\blueimp\helpers;

use iamwebdesigner\blueimp\assets\VideoAsset;

class Video extends BaseItems
{
    /**
     * Default MIME type of a video
     * @var string
     */
    public $type = 'video/mp4';
    public $posterUrlTemplate = '{url}';
    public $videoSourcesProperty = 'sources';
    public $videoPosterProperty = 'poster';

    /**
     * @param array|string $item to add to the list
     */
    public function addItem($item)
    {
        $item = (array)$item;
        if (empty($item[$this->urlProperty]) && empty($item[0])) {
            return;
        }
        if (isset($item[0])) {
            $this->setProperty($item, $this->urlProperty, str_replace('{url}', $item[0], $this->urlTemplate));
            $this->setProperty($item, $this->videoPosterProperty, $this->urlSetClosure($item[0], $this->posterUrlTemplate));
        }
        $this->setProperty($item, $this->typeProperty, $this->type);
        $this->_items[] = $item;
    }

    public function setPluginProperties(&$options)
    {
        parent::setPluginProperties($options);
        $options['videoSourcesProperty'] = $this->videoSourcesProperty;
        $options['videoPosterProperty'] = $this->videoPosterProperty;
    }

    /**
     * Register assets
     * @param \yii\web\View $view
     */
    public function registerAssets($view)
    {
        VideoAsset::register($view);
    }
}