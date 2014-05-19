yii2-talma-chained-widget
===========
Widget for Yii Framework 2.0 to use [jquery_chained](https://github.com/tuupola/jquery_chained)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thiagotalma/yii2-chained "*"
```

or add

```
"thiagotalma/yii2-chained": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by :

```php
<?= \talma\widget\Chained::widget(); ?>;
```