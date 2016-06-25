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
         if (!$session->isActive){
             $session->open();
         }
         //角色
         $role_list = MemberRole::find()->where(['member_id'=>$member_id])->all();
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
         $privileges = Privilege::find()->where(['id'=>$privilege_ids,'pid'=>0])->all();

         $session->set("privilege_ids",$privilege_ids);

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
        if (!$session->isActive){
            $session->open();
        }
        $privilege_ids = $session->get("privilege_ids");

        if($member_type == 2){
            $privileges = Privilege::find()->where(['id'=>$privilege_ids,'pid'=>$pid])->all();
            $menu = Array('data'=>$privileges);
            return Json::encode($menu);
        }else{

            $menu = Array('data'=>[]);
            return Json::encode($menu);
        }

    }
}

?>
