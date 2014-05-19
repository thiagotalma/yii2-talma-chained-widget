<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-chained-widget
 * @version 1.0.0
 */

namespace talma\widgets;

use yii\web\AssetBundle;

/**
 * Asset bundle for Chained Widget
 *
 * @author Thiago Talma <thiago@thiagomt.com>
 * @since 1.0
 */
class ChainedAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->js = ['jquery.chained.remote.js'];
        $this->sourcePath = __DIR__ . '/../assets';
        parent::init();
    }
}
