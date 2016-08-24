<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/7/27
 * Time: 15:57
 */

namespace backend\assets;

use yii\web\AssetBundle;
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/indlog.css',
    ];

}