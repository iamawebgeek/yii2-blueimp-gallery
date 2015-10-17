<?php

namespace iamwebdesigner\blueimp\helpers;

use yii\base\Object;

/**
 * Class BaseItems
 * @author iamwebdesigner
 * @property string $type Item MIME Type
 * @property array $items Array of items
 * @property boolean $enableLinksRendering Enable rendering the links
 */
abstract class BaseItems extends Object
{
    public $thumbnailProperty = 'thumbnail';
    public $titleProperty = 'title';
    public $typeProperty = 'type';
    public $urlProperty = 'href';
    public $urlTemplate = '{url}';

    /**
     * @var array list of items
     */
    protected $_items = [];

    /**
     * @return array return list of items
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * @return bool
     */
    public function getEnableLinksRendering()
    {
        return false;
    }

    /**
     * Combine current items list with another items list generating component
     * @param BaseItems $baseItems
     * @return $this
     */
    public function combine(BaseItems $baseItems)
    {
        $this->_items = array_merge($this->_items, $baseItems->getItems());
        return $this;
    }

    /**
     * @param array $items list of items to add
     * @param bool $reset
     * @return $this
     * @see addItem
     */
    public function setItems(array $items, $reset = true)
    {
        if ($reset) {
            $this->_items = [];
        }
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    public function setPluginProperties(&$options)
    {
        $options['urlProperty'] = $this->urlProperty;
        $options['typeProperty'] = $this->typeProperty;
        $options['titleProperty'] = $this->titleProperty;
    }

    /**
     * @param string $id HTML Id attribute of the gallery plugin
     * @param array $linkOptions Link HTML options
     * @param array $imageOptions Image HTMl options
     * @return string Rendered result
     */
    public function renderLinks($id, $linkOptions, $imageOptions)
    {
        return null;
    }

    /**
     * @param array $array Item array
     * @param string $property Property name
     * @param mixed $value Value to set
     */
    protected function setProperty(array &$array, $property, $value)
    {
        if (!isset($array[$property]) && $property !== null) {
            $array[$property] = $value instanceof \Closure ? $value() : $value;
        }
    }

    /**
     * @param $value string
     * @return \Closure|null
     */
    protected function urlSetClosure($value, $template, $replaceElement = 'url')
    {
        if ($value === null) {
            return $value;
        }
        return function () use($value, $template, $replaceElement) {
            return str_replace(sprintf('{%s}', $replaceElement), $value, $template);
        };
    }

    /**
     * @param array|string $item to add to the list
     */
    abstract public function addItem($item);

    /**
     * Register assets
     * @param \yii\web\View $view
     */
    abstract public function registerAssets($view);
}