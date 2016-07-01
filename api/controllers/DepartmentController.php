<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/22
 * Time: 14:46
 */

namespace api\controllers;
use yii\web\Controller;
use Yii;
use api\utils\MethodUtil;
class DepartmentController extends Controller
{
    public $date;
    public function getDate(){
        return $this->date = date('Ymd' , strtotime('-1 day'));
    }
    public function actionGeneral(){
        $connection = \Yii::$app->stock;
        $connection->open();
        $date = $this->getDate();
        $sql = "exec kg_xzq212801 '$date'";
        $command = $connection->createCommand($sql);
        $res = $command->queryAll();
        $connection->close();
        $arr = array(
            'data'=>$res
        );
        echo json_encode($arr);
    }

    public function actionShopDay(){
        $connection = \Yii::$app->stock;
        $connection->open();
        $date = $this->getDate();
        $sql = "exec kg_xzq212802 '$date'";
        $command = $connection->createCommand($sql);
        $posts = $command->queryAll();
        $res = MethodUtil::var_encode($posts);
        $arr = array(
            'data'=>$res
        );
        echo json_encode($arr);
    }
    public function actionShop(){
        $shopid = Yii::$app->request->get('shopid');
        $connection = \Yii::$app->stock;
        $connection->open();
        $sql = "exec kg_xzq212803";
        $command = $connection->createCommand($sql);
        $posts = $command->queryAll();
        $res = array();
        foreach($posts as $row){
            if($row['shopid']==$shopid){
                $res[]=$row;
            }
        }
        $total=array();
        $total['dateid']='合计';
        $total['salevalue']=0;
        $total['ysalevalue']=0;
        $total['ysalegain']=0;
        $total['maol']=0;
        foreach($res as $row){
            $total['salevalue'] += $row['salevalue'];
            $total['ysalevalue'] += $row['ysalevalue'];
            $total['ysalegain'] += $row['ysalegain'];
            $total['maol'] += $row['maol'];
        }
        $total['dcc'] = $total['maol']/$total['ysalegain'];
        $total['lv'] = $total['maol']/$total['salevalue'];
        $res[]=$total;
        for($i=0;$i<count($res)-1;$i++){
            $res[$i]['zhanbi']=$res[$i]['salevalue']/$res[count($res)-1]['salevalue']*100;
        }
        $arr = array(
            'data'=>$res
        );
        echo json_encode($arr);
    }

}
