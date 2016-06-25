<?php

namespace api\controllers;

use api\models\Privilege;
use api\models\MemberRole;
use api\models\RolePrivilege;
use Yii;
use yii\web\Controller;
use yii\helpers\Json;

/**
 * PrivilegeController implements the CRUD actions for Privilege model.
 */
class PrivilegeController extends Controller
{
     public function actionMenu($member_id,$member_type){
         $session = Yii::$app->session;
         $session->readSession("121");

         $privileges = Privilege::find()
                       ->where(['id'=>$session->get("privileges"),'pid'=>0,'privilegetype'=>0,'state'=>1])
                       ->select(['id','name','title','url','pid'])->all();
         $result = Array('data'=>$privileges);
        //集团员工
        if($member_type == 2){
            return Json::encode($result);
        }else{
            //1.会员详细信息
            $memcontent = Memcontent::find()->where(['uid'=>$member_id])->one();
            $result["memcontent"] = $memcontent;
            //2.查询电子会员卡图片。如果不经存在则生成新会员卡图片。
            //3.查询会员积分、零钱包
            //4.查询最新活动通知
        }
     }

    public function actionSubmenu($pid,$member_id,$member_type){
        $session = Yii::$app->session;
        $privilege_ids = $session->get("privileges");
        if(!$privilege_ids){
            $privilege_ids = [];
        }
        if($member_type == 2){
            $privileges = Privilege::find()
                          ->where(['id'=>$privilege_ids,'pid'=>$pid,'privilegetype'=>0,'state'=>1])
                          ->select(['id','name','title','url','pid'])->all();

            $menu = Array('data'=>$privileges);
            return Json::encode($menu);
        }else{

            $menu = Array('data'=>[]);
            return Json::encode($menu);
        }

    }
}

?>
