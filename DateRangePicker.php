<?php
/**
 * @author Bogdan Burim <bgdn2007@ukr.net> 
 */

namespace bburim\daterangepicker;

use Yii;
use yii\base\Model;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget as Widget;
use yii\base\InvalidConfigException;

class DateRangePicker extends Widget
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var yii\base\Model $model
     */
    public $model;

    /**
     * @var string $attribute
     */
    public $attribute;

    /**
     * @var string JS Callback for Daterange picker
     */
    public $callback;
    /**
     * @var array Options to be passed to daterange picker
     */
    public $options = [];
    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = [];
    /**
     * @var string the type of the input tag. Currently only 'text' and 'tel' are supported.
     * @see https://github.com/RobinHerbots/jquery.inputmask
     * @since 2.0.6
     */
    public $type = 'text';


    public $moment = true;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        if ($this->name === null && !$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            $this->id = Html::getInputId($this->model, $this->attribute);
            $this->registerJs('#'.$this->htmlOptions['id'], $this->options, $this->callback);
            return Html::activeInput($this->type, $this->model, $this->attribute, $this->htmlOptions + ['class' => 'form-control'] );
        } else {
            $this->registerJs('#'.$this->htmlOptions['id'], $this->options, $this->callback);
            return Html::input($this->type, $this->name, $this->value, $this->htmlOptions);
        }
    }

    protected function registerJs($selector, $options, $callback)
    {
        $view = $this->getView();

        DateRangePickerAsset::register($view);

        $js = '$("' . $selector . '").daterangepicker(' . Json::encode($options) . ($callback ? ', ' . Json::encode($callback) : '') . ');';
        $view->registerJs($js,View::POS_READY);

    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}

