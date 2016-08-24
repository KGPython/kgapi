<?php
use yii\helpers\Html;

use backend\assets\BaseAsset;
use backend\assets\HackAsset;
use backend\assets\LoginAsset;
use yii\bootstrap\ActiveForm;

BaseAsset::register($this);
HackAsset::register($this);
LoginAsset::register($this);

$rootMy = new BaseAsset();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('登录中心_ERP后台管理系统') ?></title>
    <link rel="icon" href="<?=$rootMy->baseUrl;?>/favicon.ico" type="image/gif" />
    <style>
        .help-block{
            position: absolute;
            right: -120px;
            top: 0px;
        }
        #loginform-verifycode-image{margin-left: 10px;}
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container">
    <div id="logo">
        <img src="<?=$rootMy->baseUrl;?>/images/erp_login.png" alt="logo">
    </div>
    <div class="loginform"  id="loginbox">
        <?php $form = ActiveForm::begin([
            "action"=>["member/login"],
            "method"=>"post"
        ]); ?>
            <div class="form-group icons-lg">
                <span class="icons-user"></span>
                <?=$form->field($model,'username')->textInput(['class' => 'form-control', 'id' => 'username', 'placeholder'=>'请输入账号', 'required'=>'required'])->label(false)?>
            </div>
            <div class="form-group icons-lg">
                <span class="icons-psd"></span>
                <?=$form->field($model,'password')->textInput(['class' => 'form-control', 'id' => 'password', 'placeholder'=>'请输入密码', 'required'=>'required'])->label(false)?>
            </div>
            <div class="form-group icons-lg" >

                <?=$form->field($model, 'verifyCode')->label(false)->widget(yii\captcha\Captcha::className(), [
                    'captchaAction'=>"member/captcha",
                    'template' => '<div class="col-xs-6">{input}</div><div  class="col-xs-6">{image}</div>',
                    'imageOptions'=>['alt'=>'点击换图','title'=>'点击换图', 'style'=>'cursor:pointer'],
                    'options'=>['placeholder'=>'验证码','class'=>'form-control','required'=>'required']
                ]) ?>
            </div>
            <div class="form-group" >
                <?= Html::submitButton('登录', ['class' => 'btn btn-success bg_lg', 'name' => 'login-button','type'=>'submit']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

