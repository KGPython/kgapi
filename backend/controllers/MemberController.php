<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\User;
use yii\filters\VerbFilter;
use yii\captcha\CaptchaValidator;

/**
 * Site controller
 */
class MemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','login'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' =>  [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor'=>0xf491f4,
                'padding'=>2,
                'height'=>35,
                'maxLength'=>4,
                "offset"=>2,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $username = isset($_REQUEST["username"])?$_REQUEST["username"]:"";
        $password = isset($_REQUEST["password"])?$_REQUEST["password"]:"";
        $verifyCode = isset($_REQUEST["verifyCode"])?$_REQUEST["verifyCode"]:"";

        $model = new LoginForm();
        if($verifyCode){

            $caprcha = new CaptchaValidator();
            $flag = $caprcha->validate($verifyCode);
            if ($flag && $this->login($username,$password)) {
                return $this->goHome();
            } else {
                return $this->renderPartial('login', [ 'model' => $model, ]);
            }
        }
        else {
            return $this->renderPartial('login', [ 'model' => $model, ]);
        }
        return $this->renderPartial('login');
    }

    function login($username,$password){
        $user = User::findByUsername($username);
        if($user){
            return True;
        }else{
            return False;
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
