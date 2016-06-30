<?php
/**
 * Created by PhpStorm.
 * User: he
 * Date: 2016-6-28
 * Time: 17:11
 */
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use api\utils\MethodUtil;

/**
 *
 */
class LogisticsController extends Controller
{
    public function actionGroups(){
        $msg = Array();
        try {
            $connection = \Yii::$app->logistics;
            $connection->open();

            $sql = "select b.deptid/1000000 as deptid,c.name,sum(qty) as qty,sum(costvalue) as costvalue 
                    from shopsstock a,goods b,sgroup c where shopid='C00L' 
                    and a.goodsid=b.goodsid and qty<>0 and c.id=b.deptid/1000000 
                    group by b.deptid/1000000,c.name order by b.deptid/1000000";

            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();
            $result = Array();

            if(count($data_list)>0){
                $sum = Array("deptid"=>"合计","name"=>"","qty"=>0.0,"costvalue"=>0.0);
                foreach ($data_list as $data){
                    $sum["qty"] += $data["qty"];
                    $sum["costvalue"] += $data["costvalue"];

                    $data["qty"] = strval(round($data["qty"],2));
                    $data["costvalue"] =  strval(round($data["costvalue"],2));

                    $result[] = $data;
                }

                $sum["qty"] =  round($sum["qty"],2);
                $sum["costvalue"] =  round($sum["costvalue"],2);
                $result = MethodUtil::var_encode($result);
                $result[] = $sum;
            }
            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
        }
        return Json::encode($msg);
    }

    public function actionDispatch($type){
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
//        $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        $today = date("Y-m-d");
        if($type === 'total'){
            $msg = $this->findDispath($start,$today);
        }else{
            $msg = $this->findDispath($today,$today);
        }

        return Json::encode($msg);
    }

    private function findDispath($start,$end){

        $msg = Array();
        try {
            $connection = \Yii::$app->logistics;
            $connection->open();

            $sql = "select a.outshopid,a.inshopid,sum(b.qty) as qty,sum(b.qty*b.cost) as costvalue,
                    sum(b.qty*b.cost/(1+b.taxrate/100)) as nvalue,a.rationtype 
                    from ration a,rationcostitem b,goods c,vender v where a.sheetid=b.sheetid 
                    and a.flag=100 and b.goodsid=c.goodsid and b.venderid=v.venderid 
                    and convert(char(10),a.checkdate,120) between '".$start."' and '".$end."' 
                    group by a.outshopid,a.inshopid,a.rationtype 
                    order by a.rationtype,a.outshopid,a.inshopid";
            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();

            $shop_sql = "select id,name from shop where shoptype in (13,11,21)";
            $command = $connection->createCommand($shop_sql);
            $shop_list = $command->queryAll();
            $shop_dict = Array();
            foreach ($shop_list as $shop){
                $shop_dict[$shop["id"]] = $shop["name"];
            }
            //$shop_dict["C00L"] = "物流";

            $result = Array();
            $list = Array();

            if(count($data_list)>0){
                $sum = Array("insum"=>0,"insum2"=>0.0,"outsum"=>0,"outsum2"=>0.0,"totalsum"=>0,"totalsum2"=>0.0);
                foreach ($data_list as $data){
                    $rationtype = trim($data["rationtype"]);
                    if($rationtype=="I"){
                        $sum["insum"] += $data["costvalue"];
                        $sum["insum2"] += $data["nvalue"];
                    }elseif ($rationtype=="O"){
                        $sum["outsum"] += $data["costvalue"];
                        $sum["outsum2"] += $data["nvalue"];
                    }

                    $sum["totalsum"] += $data["costvalue"];
                    $sum["totalsum2"] += $data["nvalue"];

                    $data["outshopid"] = $shop_dict[$data["outshopid"]];
                    $data["inshopid"] = $shop_dict[$data["inshopid"]];

                    $data["qty"] = round($data["qty"],2);
                    $data["costvalue"] =  round($data["costvalue"],2);
                    $data["nvalue"] =  round($data["nvalue"],2);

                    $list[] = $data;
                }
                $result["data_list"] = MethodUtil::var_encode($list);
                $result["sum"] = $sum;
            }

            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
        }
        return $msg;
    }

    public function actionReturn(){
        $msg = Array();
        try {
            $connection = \Yii::$app->logistics;
            $connection->open();
            //日期 数量 含税金额 未含金额
            $sql = "select convert(char(10),sdate,120) rq,sum(qty) qty,
                  SUM(costvalue) costvalue,sum(costvalue-costtaxvalue) uncostvalue
                  from WasteBook where sheettype in ('2323','2301') 
                  group by convert(char(10),sdate,120) 
                  order by convert(char(10),sdate,120)";

            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();
            $result = Array();
            if(count($data_list)>0){
                $sum = Array("rq"=>"合计","qty"=>0.0,"costvalue"=>0.0,"uncostvalue"=>0.0);
                foreach ($data_list as $data){
                    $sum["qty"] += $data["qty"];
                    $sum["costvalue"] += $data["costvalue"];
                    $sum["uncostvalue"] += $data["uncostvalue"];

                    $data["qty"] = round($data["qty"],2);
                    $data["costvalue"] = round($data["costvalue"],2);
                    $data["uncostvalue"] = round($data["uncostvalue"],2);

                    $result[] = $data;
                }
                $sum["qty"] = round($sum["qty"],2);
                $sum["costvalue"] = round($sum["costvalue"],2);
                $sum["uncostvalue"] = round($sum["uncostvalue"],2);
                $result = MethodUtil::var_encode($result);
                $result[] = $sum;
            }
            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
        }
        return Json::encode($msg);
    }
}

?>
