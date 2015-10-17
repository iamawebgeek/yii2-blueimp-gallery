<?php


namespace iamwebdesigner\blueimp\helpers;


use iamwebdesigner\blueimp\assets\YouTubeAsset;

class YouTube extends Video
{
    public $type = 'text/html';
    public $youTubeVideoIdProperty = 'youtube';
    public $posterUrlTemplate = 'https://img.youtube.com/vi/{youtube}/maxresdefault.jpg';
    public $urlTemplate = 'https://www.youtube.com/watch?v={youtube}';

    /**
     * @param array|string $item to add to the list
     */
    public function addItem($item)
    {
        $item = (array)$item;
        if (empty($item[$this->youTubeVideoIdProperty]) && empty($item[0])) {
            return;
        }
        if (isset($item[0])) {
            $this->setProperty($item, $this->videoPosterProperty, $this->urlSetClosure($item[0], $this->posterUrlTemplate, 'youtube'));
            $this->setProperty($item, $this->youTubeVideoIdProperty, $item[0]);
            $this->setProperty($item, $this->urlProperty, str_replace('{youtube}', $this->urlTemplate, $item[0]));
        }
        $this->setProperty($item, $this->typeProperty, $this->type);
        $this->_items[] = $item;
    }

    public function setPluginProperties(&$options)
    {
        parent::setPluginProperties($options);
        $options['youTubeVideoIdProperty'] = $this->youTubeVideoIdProperty;
    }

    /**
     * Register assets
     * @param $view \yii\web\View
     */
    public function registerAssets($view)
    {
        YouTubeAsset::register($view);
    }
}