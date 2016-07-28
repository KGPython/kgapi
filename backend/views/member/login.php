<?php
use yii\helpers\Html;
use backend\assets\AppAsset;
use backend\assets\BootstrapAsset;
use yii\bootstrap\ActiveForm;


BootstrapAsset::register($this);
AppAsset::register($this);
$appAsset = new AppAsset();
$bootstrapAsset = new BootstrapAsset();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('登录中心_ERP后台管理系统') ?></title>
    <link rel="icon" href="<?=$appAsset->baseUrl;?>/favicon.ico" type="image/gif" />
    <!--[if lt IE 9]>
    <script src="<?=$bootstrapAsset->baseUrl;?>/js/html5shiv.js"></script>
    <script src="<?=$bootstrapAsset->baseUrl;?>/js/respond.min.js"></script>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container">
    <div id="logo">
        <img src="<?=$bootstrapAsset->baseUrl;?>/images/erp_login.png" alt="logo">
    </div>
    <div class="loginform"  id="loginbox">
        <?php $form = ActiveForm::begin(["action"=>["member/login"],"method"=>"post"]); ?>
            <div class="form-group icons-lg">
                <span class="icons-user"></span>
                <?= Html::input('text','username', '', ['class' => 'form-control', 'id' => 'username', 'placeholder'=>'请输入账号', 'required'=>'required']) ?>
            </div>
            <div class="form-group icons-lg">
                <span class="icons-psd"></span>
                <?= Html::input('password','password', '', ['class' => 'form-control', 'id' => 'password', 'placeholder'=>'请输入密码', 'required'=>'required']) ?>
            </div>
            <div class="form-group icons-lg" >
                <div class="col-xs-6" style="width:100%;">
                    <?=$form->field($model, 'verifyCode')->label(false)->widget(yii\captcha\Captcha::className(), [
                        'captchaAction'=>"member/captcha",
                        'template' => '<label style="width: 50%;"><input type="text" class="form-control" name="verifyCode" placeholder="验证码" ></label><label style="width:40%;margin-left:10px;">{image}</label>',
                        'imageOptions'=>['alt'=>'点击换图','title'=>'点击换图', 'style'=>'cursor:pointer'],
                        'options'=>['placeholder'=>'验证码','class'=>'form-control','required'=>'required']
                    ]) ?>
                </div>
            </div>
            <div class="form-group" >
                <?= Html::submitButton('登录', ['class' => 'btn btn-default col-lg-3', 'name' => 'login-button']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default col-sm-offset-1 col-lg-3', 'name' => 'reset-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

