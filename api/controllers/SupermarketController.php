<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/6/23
 * Time: 16:11
 */

namespace api\controllers;

use yii\web\Controller;
use api\utils\MethodUtil;
class SupermarketController extends Controller
{
    public function actionGeneralDayT1(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sqlGeneral = "exec kg_xzq112801 '$date'";
        $commGeneral = $conn->createCommand($sqlGeneral);
        $resGeneral = $commGeneral->queryAll();

        $sqlPercent = "exec kg_xzq112809 '$date'";
        $commPercent = $conn->createCommand($sqlPercent);
        $resPercent = MethodUtil::var_encode($commPercent->queryAll());
        $conn->close();
        $res = array_merge($resGeneral,$resPercent);
        $arr = array('data'=>$res);
        echo json_encode($arr);

    }

    public function actionGeneralDayT2(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sqlStatus = "exec kg_xzq999900 '$date'";
        $commStatus = $conn->createCommand($sqlStatus);
        $resStatus = MethodUtil::var_encode($commStatus->queryAll());
        $conn->close();
        $arr = array('data'=>$resStatus);
        echo json_encode($arr);
    }

    public function actionGeneralMonth(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "exec kg_xzq112810 '$date'";
        $comm = $conn->createCommand($sql);
        $res= $comm->queryAll();
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }

    public function actionGeneralCate(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "exec kg_xzq112811 '$date'";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }

    public function actionGeneralShop(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $date = date('Ymd',strtotime('-1 day'));
        $sql = "exec kg_xzq112812 '$date'";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $total = array();
        $total['name']='合计';
        $total['salevalueesti']=0;
        $total['salegainesti']=0;
        $total['salevalueestil']=0;
        $total['salegainestil']=0;
        $total['truevalueall']=0;
        $total['gainall']=0;
        foreach($res as $row){
            $total['salevalueesti'] += $row['salevalueesti'];
            $total['salegainesti'] += $row['salegainesti'];
            $total['salevalueestil'] += $row['salevalueestil'];
            $total['salegainestil'] += $row['salegainestil'];
            $total['truevalueall'] += $row['truevalueall'];
            $total['gainall'] += $row['gainall'];
        }
        $total['ml'] =  $total['gainall'] / $total['truevalueall'] * 100;
        $total['xdc']  =  $total['truevalueall'] / $total['salevalueestil'] * 100;
        $total['cdc'] = $total['gainall'] / $total['salegainestil'] * 100;
        $conn->close();
//        array_push($res,$total);
        $res[]=$total;
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }

    public function actionGeneralNowShop(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq112813";
        $comm= $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $total = array();
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
    public function actionGeneralNowDept(){
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq112814";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
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
    public function actionShopOperate(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq112802 '$date'";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }
    public function actionShopDod(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq112803 '$date'";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }

    public function actionShopSlShop(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sqlShop = "select shopid,name,sum(s801) SKU1,sum(s802) SKU2,sum(S803) SKU3,sum(S804) SKU4,sum(S806) SKU6,
                    sum(S807) SKU7,sum(S809) SKU9,sum(S810L)  SKU10,sum(S801_1)  SKU11,
                    case sum(s810l) when 0 then 0 else sum(s810L+S801_1-s801-s802-s803-s804)/sum(s810L+S801_1)*100 end as SL
                    from KG_s810 a,shop_KG b where bbdate='$date' and a.shopid=b.id group by shopid,name order by a.shopid";
        $commShop = $conn->createCommand($sqlShop);
        $resShop= MethodUtil::var_encode($commShop->queryAll());
        $conn->close();
        $arr = array('data'=>$resShop);
        echo json_encode($arr);
    }
    public function actionShopSlDept(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sqlDept = "select b.id , b.name,sum(s801) SKU1,sum(s802) SKU2,sum(S803) SKU3,sum(S804) SKU4,sum(S806) SKU6,
                    sum(S807) SKU7,sum(S809) SKU9,sum(S810L) SKU10,sum(S801_1) as SKU11,
                    case sum(s810L+S801_1) when 0 then 0 else sum(s810L+S801_1-s801-s802-s803-s804)/sum(s810L+S801_1)*100 end as SL
                    from KG_s810 a,SGroup b
                    where b.deptlevelid='2' and a.deptid/1000000=b.id and bbdate='$date' and shopid in (select id from shop_KG) group by b.id ,b.name order by b.id";
        $commDept = $conn->createCommand($sqlDept);
        $resDept = MethodUtil::var_encode($commDept->queryAll());
        $conn->close();
        $arr = array('data'=>$resDept);
        echo json_encode($arr);
    }
    public function actionShopCate(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "exec kg_xzq112804 '$date'";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }
    public function actionShopRepertory(){
        $date = date('Ymd',strtotime('-1 day'));
        $conn = \Yii::$app->stock;
        $conn->open();
        $sql = "select b.name,deptname,startvalue,endvalue,zzdays,zzrate,days
                from KG_SaleCost a,shop_KG b where a.sdate='$date' and a.shopid=b.id and deptid in ('1','2','3')
                order by sdate,shopid,deptid";
        $comm = $conn->createCommand($sql);
        $res= MethodUtil::var_encode($comm->queryAll());
        $conn->close();
        $arr = array('data'=>$res);
        echo json_encode($arr);
    }
}