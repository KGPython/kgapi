<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/7/27
 * Time: 16:07
 */

namespace backend\assets;

use yii\web\AssetBundle;
class ImgAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/indlog.css',
    ];

}