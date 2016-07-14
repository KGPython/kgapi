<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/23
 * Time: 13:35
 */
namespace api\controllers;
use yii\web\Controller;
use api\utils\MethodUtil;
class CvsController extends Controller
{
    public function actionGeneral(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "exec kg_xzq312801 '$date'";
        $comm = $conn -> createCommand($sql);
        $res = $comm->queryAll();
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }

    public function actionShopDay(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "exec kg_xzq312802 '$date'";
        $comm = $conn -> createCommand($sql);
        $res = MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $temp = array();
        foreach($res as $row){
            if($row['id']!='D007' && $row['id']!='D010'){
                $temp[]=$row;
            }
        }
        $arr = array('data'=>$temp);
        echo json_encode($arr);
    }
    public function actionShopNowShop(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq512804";
        $comm = $conn -> createCommand($sql);
        $res = MethodUtil::var_encode($comm->queryAll());
        $conn->close();

        $total= array();
        $total['name']='合计';
        $total['lks']=0;
        $total['saleqty']=0;
        $total['salevalue']=0;
        foreach($res as $row){
            $total['lks'] += $row['lks'];
            $total['saleqty'] += $row['saleqty'];
            $total['salevalue'] += $row['salevalue'];
        }
        $total['kdj'] = $total['salevalue']/$total['lks'];
        $res[]=$total;
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }
    public function actionShopNowDept(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq512805";
        $comm = $conn -> createCommand($sql);
        $res = MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $salesTotal = 0;
        foreach($res as $row){
            $salesTotal += $row['salevalue'];
        }
        for($i=0;$i<count($res);$i++){
            $res[$i]['zhanbi'] = $res[$i]['salevalue']/$salesTotal*100;
        }
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }
    public function actionSl(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "select  shopid,name,sum(s801) SKU1,sum(s802) SKU2,sum(S803) SKU3,
                sum(S804) SKU4,sum(S806) SKU6,sum(S807) SKU7,sum(S809) SKU9,sum(S810L) SKU10,sum(S801_1) SKU11,
                 case sum(s810l) when 0 then 0 else sum(s810L+S801_1-s801-s802-s803-s804)/sum(s810L+S801_1)*100 end as SL
                 from KG_s810 a,shop b where bbdate='$date' and a.shopid=b.id
                 and b.id like 'D%'
                 and b.enable='1'
                 group by shopid,name
                 order by a.shopid";
        $comm = $conn -> createCommand($sql);
        $res = MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr,true);
    }

    public function actionTest(){
        return $this->render('test');
    }
}