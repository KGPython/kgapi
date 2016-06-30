<?php

namespace api\controllers;

use api\models\Privilege;
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
         $privilege_ids = $session->get("privileges");
         if(!$privilege_ids){
             $privilege_ids = [];
         }
         $privileges = Privilege::find()
                       ->where(['id'=>$privilege_ids,'pid'=>0,'privilegetype'=>0,'state'=>1])
                       ->select(['id','name','title','url','pid'])->orderBy('seq asc')->all();
         $result = Array('data'=>$privileges);

         return Json::encode($result);
     }

    public function actionSubmenu($pid,$member_id,$member_type){
        $session = Yii::$app->session;
        $privilege_ids = $session->get("privileges");
        if(!$privilege_ids){
            $privilege_ids = [];
        }
        $privileges = Privilege::find()
            ->where(['id'=>$privilege_ids,'pid'=>$pid,'privilegetype'=>0,'state'=>1])
            ->select(['id','name','title','url','pid'])->orderBy('seq asc')->all();

        $menu = Array('data'=>$privileges);

        return Json::encode($menu);
    }
}

?>
