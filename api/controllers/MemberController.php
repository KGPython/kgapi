<?php

namespace api\controllers;

use api\models\MemberAuxiliary;
use api\models\MemberRole;
use api\models\Members;
use api\models\Privilege;
use api\models\RolePrivilege;
use Yii;
use api\models\Memcontent;
use api\models\MemcontentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * MemberController implements the CRUD actions for Memcontent model.
 */
class MemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Memcontent models.
     * @return mixed
     */
    public function actionLogin($username,$password)
    {
        $session = Yii::$app->session;
        $session->setId(md5("127.0.0.1"));
        
        $msg = Array();
        //会员账号信息
        $member = Members::find()->where(['username'=>$username])->one();
        if($member != null){
            $pwd = md5(md5($password).$member->salt);
            if($pwd == $member->password){
                //角色
                $role_list = MemberRole::find()->where(['member_id'=>$member->uid])->all();
                $role_ids = [];
                if(count($role_list)>0){
                    foreach($role_list as $role){
                        $role_ids[] = $role['role_id'];
                    }
                }
                //查询员工菜单
                $role_privilege = RolePrivilege::find()->where(['role_id'=>$role_ids])->all();
                $privilege_ids = [];
                if(count($role_privilege)>0){
                    foreach($role_privilege as $rp){
                        $privilege_ids[] = $rp['privilege_id'];
                    }
                }
                //查询会员类型
                $memauxiliary = MemberAuxiliary::find()->where(['member_id'=>$member->uid])->one();

                $session->set("privileges",$privilege_ids);
                $session->set("member",$member);
                $session->set("memauxiliary",$memauxiliary);

                $msg['member_type'] = $memauxiliary->member_type;
                $msg['member_id'] = $member->uid;
                $msg['msg']='success';
            }else{
                $msg['msg']='密码错误';
            }
        }else{
            $msg['msg']='用户不存在';
        }

        return Json::encode($msg);
    }

    public function actionChange($membertype){

         if($membertype == 2){
             //查询员工菜单
         }else{
             //1.查询客户菜单
             //2.查询电子会员卡图片。如果不经存在则生成新会员卡图片。
             //3.查询会员积分、零钱包
             //4.查询最新活动通知
         }
    }

    /**
     * Displays a single Memcontent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Memcontent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Memcontent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
