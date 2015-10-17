<?php

namespace iamwebdesigner\blueimp\helpers;

use iamwebdesigner\blueimp\assets\BlueImpAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Image extends BaseItems
{
    /**
     * Default MIME type of an image
     * @var string
     */
    public $type = 'image/jpeg';
    public $imageUrlTemplate = '{url}';
    public $linkUrlTemplate = '{url}';
    public $enableLinksRendering = true;

    private $_linkUrls = [];

    /**
     * @param array|string $item to add to the list
     */
    public function addItem($item)
    {
        $item = (array)$item;
        if (empty($item[$this->urlProperty]) && empty($item[0])) {
            return;
        }
        $linkUrl = '';
        if (isset($item[0])) {
            $this->setProperty($item, $this->urlProperty, $this->urlSetClosure($item[0], $this->imageUrlTemplate));
            $linkUrl = $item[0];
            unset($item[0]);
        }
        if ($this->enableLinksRendering) {
            if ($linkUrl === '') {
                $linkUrl = isset($item['linkHref']) ? $item['linkHref'] : $item[$this->urlProperty];
            }
            $this->_linkUrls[] = str_replace('{url}', $linkUrl, $this->linkUrlTemplate);
        }
        $this->setProperty($item, $this->typeProperty, $this->type);
        $this->_items[] = $item;
    }

    public function renderLinks($id, $linkOptions, $imageOptions)
    {
        if ($this->enableLinksRendering) {
            $result = '';
            $linkOptions['data']['gallery'] = $id;
            foreach ($this->getLinkUrls() as $index => $url) {
                $currentItem = $this->_items[$index];
                $imageOptions['alt'] = $linkOptions['title'] = ArrayHelper::getValue($currentItem, $this->titleProperty);
                $image = Html::img($url, $imageOptions);
                $result .= Html::a($image, $currentItem[$this->urlProperty], $linkOptions);
            }
            return $result;
        }
        return null;
    }

    public function getLinkUrls()
    {
        return $this->_linkUrls;
    }

    public function setItems(array $items, $reset = true)
    {
        if ($reset && $this->enableLinksRendering) {
            $this->_linkUrls = [];
        }
        return parent::setItems($items, $reset);
    }

    /**
     * @param \yii\web\View $view
     */
    public function registerAssets($view)
    {
        BlueImpAsset::register($view);
    }
}