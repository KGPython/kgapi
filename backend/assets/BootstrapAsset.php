<?php
/**
 * Created by PhpStorm.
 * User: he
 * Date: 2016-7-1
 * Time: 13:39
 */
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/admin';
    public $css = [
        'css/bootstrap.min.css',
        'css/indlog.css',
    ];
    public $js = [
        'js/jquery.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];

}
?>
