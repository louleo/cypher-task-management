<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/app.css',
        'css/bootstrap.css',
        'css/jquery-ui.min.css',
        'css/jquery-ui,structure.min.css',
        'css/jquery-ui.theme.min.css',
    ];
    public $js = [
        'js/angular.js',
        'js/bootstrap.min.js',
        'js/popper.min.js',
        'js/jquery-ui.min.js',
//        'js/jquery-3.4.1.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    //must be placed so that JS file will be placed in the header tag
    public  $jsOptions =
        [
            'position' => View::POS_HEAD
        ];

}
