# Yii 2 Blueimp Gallery Widget

Yii 2 widget for working with js blueimp gallery plugin.

## About

The widget is split into two parts:  
- Widget renderer  
- Items list generator  

It is possible to use list generator without rendering component, but make sure you register necessary styles and scripts by calling `registerAssets` method of items component and pass `View` class into it.

## Installation

Composer command to install this package
```
composer require iamwebdesigner/yii2-blueimp-gallery
```

## Usage

### Using items list generator
```php
<?php
use iamwebdesigner\blueimp\helpers\YouTube;
$items = new YouTube([
	'items' => [ // enter youtube video ids as elements of the array
		'ZXsQAXx_ao0',
		'5-sfG8BV8wU',
		'DdGetnDJKCg',
	]
])->items;
```

### Using whole widget
```php
<?php
use iamwebdesigner\blueimp\BlueImpGallery;
use iamwebdesigner\blueimp\helpers\Image;
echo BlueImpGallery::widget([
    'itemsComponent' => new Image([
        'items' => [ // array of images to use, at key 0 comes image url
            ['/images/54668', 'title' => 'JavaScript'],
            ['/images/r46457', 'title' => 'Ruby'],
            ['/images/t4y5b', 'title' => 'PHP'],
            ['/images/f5h5eg', 'title' => 'C#'],
        ]
    ]),
    'clientOptions' => [ // js plugin options
        'closeOnEscape' => false
    ],
    'showIndicators' => false,
]);
?>
```