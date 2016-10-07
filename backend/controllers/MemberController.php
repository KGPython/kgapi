<?php
namespace backend\controllers;

use backend\models\RoleNav;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\User;
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
                'only' => ['logout', 'signup','login','index'],
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
//    public $defaultAction = 'login';
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' =>  [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor'=>0x000000,
                'padding'=>2,
                'height'=>35,
                'width'=>150,
                'maxLength'=>4,
                "offset"=>8,
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
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post())){
            if($model->verifyCode){
                $caprcha = new CaptchaValidator();
                $flag = $caprcha->validate($model->verifyCode);
                if($flag && $model->login()){
                    $user = User::find()->where(['username' => $model->username])->one();
                    $conn = Yii::$app->db;
                    $findNavs = 'select a.* from wap_amdin_nav as a INNER JOIN  wap_admin_role_nav as b ON a.nav_id = b.nav where role='.$user->role;
                    $comm = $conn->createCommand($findNavs);
                    $navs = $comm->queryAll();

                    $session = Yii::$app->session;
                    $session['navs']=$navs;
                    return $this->goHome();
                }
            }
        }else {
            return $this->renderPartial('login', [ 'model' => $model, ]);
        }
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
