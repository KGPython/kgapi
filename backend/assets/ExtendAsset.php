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
class ExtendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/matrix-media.css',
        'css/matrix-style.css',
        'css/backend.css',
    ];
    public $js = [
        'js/matrix.js',
    ];
    public $depends = [
        'backend\assets\BaseAsset',
    ];
}
?>
