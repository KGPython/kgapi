<?php
/**
 * Created by PhpStorm.
 * User: he
 * Date: 2016-6-29
 * Time: 14:35
 */
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use api\utils\MethodUtil;

/**
 *
 */
class ParkController extends Controller
{
    public function actionInfo(){
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
        $today = date("Y-m-d");

        $start_lastmonth = date('Y-m-01', strtotime('-1 month'));
        $today_lastmonth = date("Y-m-d", strtotime('-1 month'));

        $msg = Array();
        try {
            $connection = \Yii::$app->park;
            $connection->open();

            $sql = "SELECT convert(char(10),intime,120) as rq, count(*) as qty 
                    FROM MYCARGOOUTRECORD 
                    where intime between '".$start."' and '".$today ."' 
                    group by convert(char(10),intime,120) 
                    order by convert(char(10),intime,120) DESC";
            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();

            $shop_sql = "select cast(sum(cha)/(60*60.0) as decimal(10,2) ) as totaltime, count(*) as totalnum, 
                         cast(cast(sum(cha) as decimal(10,2)) / cast(count(*) as decimal(10,2))/(60*60) as decimal(10,2)) as avgtime
                        ,(select count(*) from MYCARGOOUTRECORD where intime between '".$start_lastmonth."' and '".$today_lastmonth."') lastqty
                        from (SELECT cph,intime,outtime,datediff(ss,intime,outtime) as cha 
                        FROM MYCARGOOUTRECORD where convert(char(10),intime,120) between convert(char(10),
                        DATEADD(mm,DATEDIFF(mm,0,getdate()),0),120) and convert(char(10),getdate()-1,120)) a 
                        where a.cha between '900' and '43201'";

            $command = $connection->createCommand($shop_sql);
            $total = $command->queryOne();

            $result = Array();

            if(count($data_list)>0){
                $sum = Array("rq"=>"合计","qty"=>0.0);
                foreach ($data_list as $data){
                    $sum["qty"] += $data["qty"];
                }
                $data_list[] = $sum;
                $total["qty"] = $sum["qty"];
                $total["growth"] = strval(round(($total["qty"]-$total["lastqty"])*100.0/$total["lastqty"],2))."%";
            }
            $result["data_list"] = $data_list;
            $result["total"] = $total;
            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
        }
        return Json::encode($msg);
    }

    public function actionExcept(){
        $msg = Array();
        try {
            $connection = \Yii::$app->park;
            $connection->open();

            $sql = "select cph,cishu,shichang from ( select cph,count(cph) as cishu,sum(datediff(ss,intime,outtime)) as shichang 
                    from MYCARGOOUTRECORD where convert(char(10),intime,120) between convert(char(10),getdate()-8,120)	
                    and convert(char(10),getdate()-1,120) group by cph ) a where a.shichang >= 36000 and a.cishu >3 
                    and a.cph not in ( SELECT cph FROM [dbo].[MYFAXINGSSUE] where cardstate <> 5 ) order by cishu desc";
            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();
            $result = Array();
            if(count($data_list)>0){
                foreach($data_list as $row){
                    $row["shichang"] = round($row["shichang"]/3600,0);
                    $result[] = $row;
                }
            }
            $msg['data'] = MethodUtil::var_encode($result);
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
        }
        return Json::encode($msg);
    }
}
?>
