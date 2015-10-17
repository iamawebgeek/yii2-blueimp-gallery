<?php


namespace iamwebdesigner\blueimp\helpers;


use iamwebdesigner\blueimp\assets\VimeoAsset;

class Vimeo extends Video
{
    public $type = 'text/html';
    public $vimeoVideoIdProperty = 'vimeo';
    public $urlTemplate = 'https://vimeo.com/{vimeo}';
    public $posterUrlTemplate = 'https://secure-b.vimeocdn.com/ts/{vimeo}.jpg';

    /**
     * @param array|string $item to add to the list
     */
    public function addItem($item)
    {
        $item = (array)$item;
        if (empty($item[$this->vimeoVideoIdProperty]) && empty($item[0])) {
            return;
        }
        if (isset($item[0])) {
            $this->setProperty($item, $this->urlProperty, str_replace('{vimeo}', $item[0], $this->urlTemplate));
            $this->setProperty($item, $this->vimeoVideoIdProperty, $item[0]);
            $this->setProperty($item, $this->videoPosterProperty, $this->urlSetClosure($item[0], $this->posterUrlTemplate, 'vimeo'));
        }
        $this->setProperty($item, $this->typeProperty, $this->type);
        $this->_items[] = $item;
    }

    public function setPluginProperties(&$options)
    {
        parent::setPluginProperties($options);
        $options['vimeoVideoIdProperty'] = $this->vimeoVideoIdProperty;
    }

    /**
     * Register assets
     * @param $view \yii\web\View
     */
    public function registerAssets($view)
    {
        VimeoAsset::register($view);
    }
}