<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/7/27
 * Time: 15:22
 */

namespace backend\assets;
use yii\web\AssetBundle;

class HackAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //$css目录：在web/css
    public $css = [];
    //$css目录：在web/js
    public $js = [
        'js/html5shiv.min.js',
        'js/respond.min.js',
    ];
    public $jsOptions = ['condition' => 'lte IE9','position' => \yii\web\View::POS_HEAD];
}