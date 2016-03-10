SibDS generators for Yii2-Gii
=============================
SibDS generators for Yii2-Gii

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sibds/yii2-sibds-gii "*"
```

or add

```
"sibds/yii2-sibds-gii": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Simply use it in your code by  :

```php
$config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'SModel' => [
                'class' => 'sibds\gii\model\Generator',
            ],
            'SModule' => [
                'class' => 'sibds\gii\module\Generator',
            ],
            'SCrud' => [
                'class' => 'sibds\gii\crud\Generator',
            ],
        ],
    ];
```