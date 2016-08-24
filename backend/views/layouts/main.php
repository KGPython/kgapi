<?php
use backend\assets\BaseAsset;
use backend\assets\ExtendAsset;
use backend\assets\HackAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

BaseAsset::register($this);
ExtendAsset::register($this);
HackAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <!--Header-part-->
    <div id="header">
        <h1><a href="#">后台管理系统</a></h1>
    </div>
    <!--close-Header-part-->

    <!--top-Header-menu-->
    <?php
    NavBar::begin([
        'brandLabel' => '宽广超市集团--企业APP管理后台',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/member/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/member/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/member/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <!--sidebar-menu-->
    <div id="sidebar"> <a class="hidden" href="#"><span class="glyphicon glyphicon-list"> </span>系统菜单</a>
        <ul>
            <li class="submenu"><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"> </span><span>后台首页</span></a></li>
            <li class="submenu"><a href="#"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> </span><span>销售管理</span></a>
                <ul>
                    <li><a href="order_create.html">创建订单</a></li>
                    <li><a href="order_details.html">订单管理</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <!--end-sidebar-menu-->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a data-original-title="Go to Home" href="#" title="" class="tip-bottom"><span class="glyphicon glyphicon-home" aria-hidden="true"> </span> 首页</a> <a href="#" class="current">Error</a></div>
        </div>


        <div class="container-fluid">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
