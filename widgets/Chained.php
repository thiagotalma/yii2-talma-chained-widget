<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-chained
 * @version 1.0.0
 */

namespace talma\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * Talma Chained widget is a Yii2 wrapper for the jquery_chained.
 *
 * @author Thiago Talma <thiago@thiagomt.com>
 * @since 1.0
 * @see https://github.com/tuupola/jquery_chained
 */
class Chained extends InputWidget
{
    /**
     * @var array Additional config
     */
    public $config = [];

    public $url;
    public $varName;
    public $parents = [];
    public $depends = [];
    public $bootstrap = [];
    public $avoidEmpty = true;
    public $loading = [];
    public $clearChildren = true;

    /**
     * @var string Hash of plugin options
     */
    public $hashOptions;

    private $_pluginName = 'chained';


    /**
     * Initializes the widget.
     * @throws InvalidConfigException if the "mask" property is not set.
     */
    public function init()
    {
        parent::init();
        if (empty($this->url)) {
            throw new InvalidConfigException('The "url" property must be set.');
        //} elseif (empty($this->varName)) {
        //    throw new InvalidConfigException('The "varName" property must be set.');
        } elseif (empty($this->parents)) {
            throw new InvalidConfigException('The "parents" property must be set.');
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $this->registerClientScript();

        $this->options['data-plugin-name'] = $this->_pluginName;
        $this->options['data-plugin-options'] = $this->hashOptions;
        $this->options['data-chained'] = $this->attribute ?: $this->name;

        Html::addCssClass($this->options, 'form-control');

        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->bootstrap, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->bootstrap, $this->options);
        }
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $options = $this->getClientOptions();
        $this->hashOptions = $this->_pluginName . '_' . hash('crc32', serialize($options));
        $id = $this->options['id'];
        $view = $this->getView();
        $view->registerJs("var {$this->hashOptions} = {$options};", $view::POS_HEAD);
        $js = "jQuery(\"#{$id}\").remoteChained({$this->hashOptions});";
        ChainedAsset::register($view);
        $view->registerJs($js);
    }

    /**
     * @return array the options for the text field
     */
    protected function getClientOptions()
    {
        $options['url'] = $this->url;
        $options['avoid_empty_request'] = $this->avoidEmpty;
        $options['clear_children'] = $this->clearChildren;
        $options['loading'] = $this->loading;
        $options['attribute'] = 'data-chained';

        if ($this->varName) {
            $options['var_name'] = $this->varName;
        }
        if (!empty($this->bootstrap)) {
            $options['bootstrap'] = $this->bootstrap;
        }

        if (!empty($this->parents)) {
            if ($this->hasModel()) {
                $parents = [];
                foreach ($this->parents as $parent) {
                    $parents[] = "#" . Html::getInputId($this->model, $parent);
                }
            } else {
                $parents = $this->parents;
            }
            $options['parents'] = $parents;
        }

        if (!empty($this->depends)) {
            if ($this->hasModel()) {
                $depends = [];
                foreach ($this->depends as $depend) {
                    $depends[] = "#" . Html::getInputId($this->model, $depend);
                }
            } else {
                $depends = $this->depends;
            }
            $options['depends'] = $depends;
        }

        $options = array_merge($options, $this->config);
        return Json::encode($options);
    }
}
