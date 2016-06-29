<?php

namespace api\controllers;

use api\models\MemberAuxiliary;
use api\models\MemberRole;
use api\models\Members;
use api\models\RolePrivilege;
use Yii;
use api\models\Memcontent;
use yii\web\Controller;
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
        //设置sessionid
        $session->setId(md5(md5($username).$password));
        
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
                //1.会员详细信息
                $memcontent = Memcontent::find()->where(['uid'=>$member->uid])->one();

                $session->set("privileges",$privilege_ids);
                $session->set("member",$member);
                $session->set("memauxiliary",$memauxiliary);
                $session->set("memcontent",$memcontent);

                $msg['mem_number'] = $memcontent->mem_number;
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
    
    public function actionCardinfo(){
        $session = Yii::$app->session;
        $memcontent = $session->get("memcontent");

        $msg = Array();
        try {
            $connection = \Yii::$app->card;
            $connection->open();

            //查询会员积分、零钱包
            $sql = "select cardno,memberid,cardtype,smallmoney,point from Guest where CardNO='".trim($memcontent->mem_number)."'";
            $command = $connection->createCommand($sql);
            $guest = $command->queryOne();

            $msg['smallmoney'] = $guest["smallmoney"];
            $msg['point'] = $guest["point"];
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
            //echo 'Caught exception: ',$e->getMessage(),'<br>';
        }
        return Json::encode($msg);
    }

    public function actionLatesthis(){
        $session = Yii::$app->session;
        $memcontent = $session->get("memcontent");

        $msg = Array();
        try {
            $connection = \Yii::$app->card;
            $connection->open();

            //查询会员最近一笔消费记录
            $sql = "select shopid,posid,listno,cashierid,gname,amount,unitname,(salevalue-discvalue) as salevalue  
                    from dbo.CardSaleGoods where cardno='".trim($memcontent->mem_number)."' 
                    and sdate in (select convert(char(10),lastusedate,120) 
                    from Guest where cardno='".trim($memcontent->mem_number)."') 
                    order by ListNo DESC";
            $command = $connection->createCommand($sql);
            $goods_list = $command->queryAll();

            $shop_sql = "select shopid,name from shop";
            $command2 = $connection->createCommand($shop_sql);
            $shop_list = $command2->queryAll();

            $shop_array = Array();
            foreach ($shop_list as $shop){
                $shop_array[trim($shop["shopid"])] = $shop["name"];
            }

            $data = Array();
            $tempid = "";

            foreach ($goods_list as $item){
               $shopid = $item["shopid"];

               if($tempid != $shopid){
                   $tempData = Array();
                   $tempData["goods_list"] = Array();
                   $tempData["posid"] =  $item["posid"];
                   $tempData["listno"] = $item["listno"];
                   $tempData["cashierid"] = $item["cashierid"];
                   $tempData["shopid"] = $shop_array[trim($shopid)];
                   $tempData["sum"] = 0.0;
                   $data[$shopid] = $tempData;
               }
                $data[$shopid]["sum"] += $item["salevalue"];
                $data[$shopid]["goods_list"][] = $item;

                $tempid = $shopid;
            }
            $result = Array();
            foreach($data as $key => $value){
                $result[] = $value;
            }

            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
            //echo 'Caught exception: ',$e->getMessage(),'<br>';
        }
        return Json::encode($msg);
    }
}
