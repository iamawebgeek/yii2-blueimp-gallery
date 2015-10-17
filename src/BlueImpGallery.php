<?php

namespace iamwebdesigner\blueimp;

use iamwebdesigner\blueimp\assets\BlueImpGalleryAsset;
use iamwebdesigner\blueimp\assets\FullScreenAsset;
use iamwebdesigner\blueimp\assets\IndicatorAsset;
use iamwebdesigner\blueimp\helpers\BaseItems;
use Exception;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class BlueImpGallery
 * @author iamwebdesigner
 */
class BlueImpGallery extends Widget
{
    /**
     * List of items
     * @var BaseItems
     */
    public $itemsComponent;
    /**
     * The options to be passed for plugin.
     * @var array
     */
    public $clientOptions = [];
    /**
     * HTML attributes for rendering container
     * @var array
     */
    public $options = [];
    /**
     * Indicators are shown or not.
     * @var array|boolean
     */
    public $showIndicators = true;
    /**
     * @var array|boolean
     */
    public $controls = ['&lsaquo;', '&rsaquo;'];
    /**
     * @var string
     */
    public $layout;

    /**
     * Content parts are held here temporarily
     * @var array
     */
    private $_content = [];

    /**
     * Default layout to be set if layout property is empty
     * @var string
     */
    public static $defaultLayout = "{slides}\n{controls}\n{close}\n{pause}\n{indicator}";

    /**
     * Initialize the widget
     * Validate options
     * @throws Exception
     */
    public function init()
    {
        if ($this->itemsComponent === null || !$this->itemsComponent instanceof BaseItems) {
            throw new Exception(\Yii::$app->translate->t('invalid value specified for parameter "{param}"', 'yii2-bluimp', ['{param}' => 'itemsComponent']));
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (!isset($this->clientOptions['container'])) {
            $this->clientOptions['container'] = '#' . $this->options['id'];
        }
        if (empty($this->layout)) {
            $this->layout = self::$defaultLayout;
        }
    }

    /**
     * Function for rendering the links
     * @param array $linkOptions
     * @param array $imageOptions
     * @return string
     */
    public function renderLinks(array $linkOptions = [], array $imageOptions = [])
    {
        return $this->itemsComponent->renderLinks($this->clientOptions['container'], $linkOptions, $imageOptions);
    }

    /**
     * Render widget
     * @return string
     */
    public function run()
    {
        $this->itemsComponent->setPluginProperties($this->clientOptions);
        $this->registerPlugin();
        $this->_content['slides'] = Html::tag($this->getClientOptionsProperty('slidesContainer'), '', ['class' => 'slides']);
        $cssClasses = ['blueimp-gallery'];

        if (ArrayHelper::getValue($this->itemsComponent, 'enableLinksRendering', false)) {
            $cssClasses[] = 'blueimp-gallery-carousel';
        }
        if ($this->controls && count($this->controls) > 0) {
            $cssClasses[] = 'blueimp-gallery-controls';
            foreach (['prevClass', 'nextClass'] as $iteration => $propertyName) {
                $control = array_slice($this->controls, $iteration, 1);
                if ($control !== []) {
                    $htmlOptions = [];
                    $key = key($control);
                    if (!is_numeric($key)) {
                        $htmlOptions = $control[$key];
                        $label = $key;
                    }
                    else {
                        $label = $control[$key];
                    }
                    Html::addCssClass($htmlOptions, [$this->getClientOptionsProperty($propertyName)]);
                    $this->_content['controls'] .= Html::a($label, null, $htmlOptions);
                }
            }
        }
        Html::addCssClass($this->options, $cssClasses);
        $this->_content['pause'] = Html::tag('div', '', ['class' => $this->getClientOptionsProperty('playPauseClass')]);
        if ($this->showIndicators) {
            $indicatorOptions = is_array($this->showIndicators) ? $this->showIndicators : [];
            Html::addCssClass($indicatorOptions, ['indicator']);
            $this->_content['indicator'] = Html::tag($this->getClientOptionsProperty('indicatorContainer'), '', $indicatorOptions);
        }
        return $this->renderContent();
    }

    /**
     * Compile content parts to one
     * @return string
     */
    protected function renderContent()
    {
        $content = Html::beginTag('div', $this->options);
        $parts = [
            'slides', 'description', 'controls',
            'close', 'pause', 'indicator', 'links'
        ];
        $partContents = [];
        $this->_content['links'] = $this->renderLinks();
        foreach ($parts as $key => $part) {
            $replacePart = '{' . $part . '}';
            $partContents[$part] = isset($this->_content[$part]) ? $this->_content[$part] : '';
            $parts[$key] = $replacePart;
        }
        $content .= str_replace($parts, $partContents, $this->layout);
        $content .= Html::endTag('div');
        return $content;
    }

    /**
     * Register plugin js
     */
    protected function registerPlugin()
    {
        $view = $this->getView();
        if ($this->showIndicators) {
            IndicatorAsset::register($view);
        }
        if (!empty($this->clientOptions['enableFullScreen'])) {
            FullScreenAsset::register($view);
        }
        $this->itemsComponent->registerAssets($view);
        BlueImpGalleryAsset::register($view);
        $id = $this->options['id'];
        $items = Json::encode($this->itemsComponent->getItems());
        $options = Json::encode($this->clientOptions);
        $view->registerJs("jQuery('#$id').blueImp($items, $options);", $view::POS_END);
    }

    /**
     * Default sensible plugin options
     * @return array
     */
    protected function getPluginDefaultOptions()
    {
        return [
            'slidesContainer' => 'div',
            'titleElement' => 'h3',
            'toggleClass' => 'toggle',
            'prevClass' => 'prev',
            'nextClass' => 'next',
            'indicatorContainer' => 'ol',
            'playPauseClass' => 'play-pause',
        ];
    }

    private function getClientOptionsProperty($name, $default = null)
    {
        $defaultOptions = $this->getPluginDefaultOptions();
        if (isset($defaultOptions[$name])) {
            $default = $defaultOptions[$name];
        }
        return ArrayHelper::getValue($this->clientOptions, $name, $default);
    }
}