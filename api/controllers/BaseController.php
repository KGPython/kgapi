<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/10/7
 * Time: 8:32
 */

namespace api\controllers;

use Yii;
use api\models\RolePrivilege;
use api\models\MemberRole;
use yii\web\Controller;
class BaseController extends Controller
{
    public function init(){
        if(is_null(Yii::$app->session->get("privileges"))){
            $uid = Yii::$app->request->get('member_id');
            $role_list = MemberRole::find()->where(['member_id'=>$uid])->all();
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
            Yii::$app->session->set("privileges",$privilege_ids);
        }
    }
}