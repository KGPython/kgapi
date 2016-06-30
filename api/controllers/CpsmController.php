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
class CpsmController extends Controller
{
    /**  承批商贸销售日报 **/
    public function actionSale(){

        $msg = Array();
        try {
            $connection = \Yii::$app->cpsm;
            $connection->open();

            $start = date('Y-m-01', strtotime(date("Y-m-d")));
            $end = date('Y-m-d', strtotime("$start +1 month -1 day"));

            $start_lastmonth = date('Y-m-01', strtotime('-1 month'));
            $end_lastmonth = date('Y-m-t', strtotime('-1 month'));

            //当月
            $data_list = $this->findSaleData($connection,$start,$end);
            //上月
            $data_list_lastmonth =  $this->findSaleData($connection,$start_lastmonth,$end_lastmonth);

            $sum_row =  $this->sumData($data_list);
            $sum_row_lastmonth =  $this->sumData($data_list_lastmonth);

            $sum_row["date"] = substr($start,5,5)."至".substr($end,5,5)."合计";
            $sum_row_lastmonth["date"] = substr($start_lastmonth,5,5)."至".substr($end_lastmonth,5,5)."合计";

            $result = Array();
            $result["data_list"] = $data_list;
            $result["sum_row"] = $sum_row;
            $result["sum_row_lastmonth"] = $sum_row_lastmonth;
            $result["data_list_lastmonth"] = $data_list_lastmonth;

            $msg['data'] = $result;
            $msg['msg'] = 'success';
            $connection->close();
        } catch (Exception $e) {
            $msg['msg'] = 'failure';
            //echo 'Caught exception: ',$e->getMessage(),'<br>';
        }
        return Json::encode($msg);
    }

    private function sumData($data_list){

        $sum = Array("date"=>"","saletotal"=>0.0,"costtotal"=>0.0,"gaintotal"=>0.0,"grossmargin"=>"",);
        if(count($data_list)>0){
            foreach ($data_list as $row){
                $sum["saletotal"] += $row["saletotal"];
                $sum["costtotal"] += $row["costtotal"];
                $sum["gaintotal"] += $row["gaintotal"];
            }

            //毛利率 = 销售毛利 * 100/ 实际销售
            $sum["grossmargin"] = strval(round($sum["gaintotal"] * 100.0 / $sum["saletotal"],2))."%";
            $sum["saletotal"] = round($sum["saletotal"], 2);
            $sum["saletotal"] = round($sum["saletotal"], 2);
            $sum["saletotal"] = round($sum["saletotal"], 2);
        }
        return $sum;
    }

    private function findSaleData($connection,$start,$end){
        //销售日期  销售收入  销售成本  销售毛利
        $sql = "select n.date, -sum(isnull(DiscountTotal,0)) as saletotal, 
                -(sum(isnull(CostTotal,0)))as costtotal, 
                (-sum(isnull(DiscountTotal,0)))-(-(sum(isnull(CostTotal,0)))) as gaintotal 
                from dlyndx n,dlySale ds,ptype p 
                where n.vchcode = ds.vchcode and ds.Ptypeid = p.Ptypeid AND (QTY<>0) 
                AND (n.DATE >= '".$start."') AND (n.DATE<= '".$end."') 
                AND (ds.PTYPEID<>'') AND p.Ptypetype = 0 
                group by n.date order by n.date desc";

        $command = $connection->createCommand($sql);
        $data_list = $command->queryAll();
        $result = Array();
        if(count($data_list)>0){
            foreach ($data_list as $item){
                $item["grossmargin"] = strval(round($item["gaintotal"] * 100.0 / $item["saletotal"],2))."%";
                $item["saletotal"] = round($item["saletotal"],2);
                $item["costtotal"] = round($item["costtotal"],2);
                $item["gaintotal"] = round($item["gaintotal"],2);
                $result[] = $item;
            }
        }
        return $result;
    }

    public function actionStock(){
        $msg = Array();
        try {
            $connection = \Yii::$app->cpsm;
            $connection->open();

            //ptypeid 品牌类型 品牌 库存数量  平均成本 库存金额
            $sql = "select left(a.ptypeid,5) ptypeid,c.pfullname ,b.pfullname,sum(qty) qty, 
                    case when sum(qty)=0 then 0 else sum(total)/sum(qty) end as pj, sum(total) costtotal
                    from dbo.GoodsStocks a,ptype b,ptype c where left(a.ptypeid,20)=b.ptypeid and left(a.ptypeid,5)=c.ptypeid 
                    group by b.pfullname,left(a.ptypeid,5),c.pfullname,left(a.ptypeid,15) order by left(a.ptypeid,15)";

            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();
            $result = Array();
            $params = Array("00007"=>mb_convert_encoding("代理品牌","GBK" ,"UTF-8"),"00008"=>mb_convert_encoding("直采品牌","GBK" ,"UTF-8"),"00009"=>mb_convert_encoding("自主品牌","GBK" ,"UTF-8"));
            if(count($data_list)>0){
                $sum = Array("ptypeid"=>"合计","pfullname"=>"","qty"=>0,"pj"=>"","costtotal"=>0.0);
                foreach ($data_list as $data){
                    $sum["qty"] += $data["qty"];
                    $sum["costtotal"] += $data["costtotal"];

                    $data["ptypeid"] = $params[$data["ptypeid"]];

                    $data["qty"] =  round($data["qty"],2);
                    $data["pj"] =  round($data["pj"],2);
                    $data["costtotal"] =  round($data["costtotal"],2);

                    $result[] = $data;
                }

                $sum["qty"] =  round($sum["qty"],2);
                $sum["costtotal"] =  round($sum["costtotal"],2);

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

    public function actionReturn(){
        $msg = Array();
        $start = date('Y-m-01', strtotime(date("Y-m-d")));
        $end = date('Y-m-d', strtotime("$start +1 month -1 day"));

        try {
            $connection = \Yii::$app->cpsm;
            $connection->open();

            //ptypeid 品牌类型 品牌 库存数量  平均成本 库存金额
            $sql = "exec p_hh_BuyAndBackStatistic_bak '".$start."','".$end."'";

            $command = $connection->createCommand($sql);
            $data_list = $command->queryAll();

            $result = Array();
            $params = Array("00007"=>mb_convert_encoding("代理品牌","GBK" ,"UTF-8"),"00008"=>mb_convert_encoding("直采品牌","GBK" ,"UTF-8"),"00009"=>mb_convert_encoding("自主品牌","GBK" ,"UTF-8"));
            if(count($data_list)>0){
                foreach ($data_list as $data){
                    //退货率 = 退货数量/进货入库数量
                    if($data["SupplyQty"]>0){
                        $data["refundrate"] = strval(round($data["BackQty"] * 100.0 / $data["SupplyQty"],2))."%";
                    }else{
                        $data["refundrate"]="";
                    }

                    $data["SupplyTotal"] = round($data["SupplyTotal"],2);
                    $data["BackTotal"] = round($data["BackTotal"],2);
                    $data["ptypeID"] = $params[trim($data["ptypeID"])];

                    $result[] = $data;
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
