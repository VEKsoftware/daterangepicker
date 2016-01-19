<?php
/**
 * @author Bogdan Burim <bgdn2007@ukr.net> 
 */

namespace bburim\daterangepicker;

use yii\web\AssetBundle;
use yii;

class DateRangePickerAsset extends AssetBundle
{

    public static $extra_js = [];

    public function init() {
        Yii::setAlias('@daterangepicker', __DIR__);

        foreach (static::$extra_js as $js_file) {
            $this->js[]= $js_file;
        }

        return parent::init();
    }

    public $sourcePath = '@bower';

    public $css = [
        'bootstrap-daterangepicker/daterangepicker.css'
    ];

    public $js = [
        'moment/moment.js',
        'bootstrap-daterangepicker/daterangepicker.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
