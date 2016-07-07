<?php
/**
 * Created by PhpStorm.
 * User: End
 * Date: 2016/7/5
 * Time: 9:59
 * 商品市调
 */
namespace api\controllers;

use yii\web\Controller;
use yii\helpers\Json;
use api\utils\MethodUtil;

class CmarketController extends Controller
{
    public $priceArr = array(); // 保存门店商品价格
    public $barcode;
    public $name;
    public $price;
    public $comment;

    public function actionQueryscan()
    {
        $msg = array();

        $this->barcode = \Yii::$app->request->get('barcode'); //商品条形码

        $results = $this->actionQueryInfo($this->barcode);
        $this->priceArr = $results;

        if (count($results) > 0) {
            $msg['name'] = $this->name;
            $msg['barcode'] = $this->barcode;
            $msg['data'] = $results;
        } else {
            $msg['name'] = '';
            $msg['barcode'] = '';
            $msg['data'] = '暂无此商品信息';
        }
        $msg = MethodUtil::var_encode($msg);
        return Json::encode($msg);
    }

    public function actionSavescan()
    {
        $msg = array();

        $this->price = \Yii::$app->request->get('price'); //商品价格
        $this->comment = \Yii::$app->request->get('comment'); // 商品备注
        $this->barcode = \Yii::$app->session['goodsbarcode'];
        $this->name = \Yii::$app->session['goodsname'];

        $this->priceArr = \Yii::$app->session['goodsinfo'];

        $this->actionSave();

        $msg['msg'] = 'success';
        $msg = MethodUtil::var_encode($msg);

        return Json::encode($msg);
    }

    public function actionSavemanual()
    {
        $msg = array();

        $this->price = \Yii::$app->request->get('price'); //商品价格
        $this->comment = \Yii::$app->request->get('comment'); // 商品备注
        $this->barcode = \Yii::$app->request->get('barcode');
        $this->name = \Yii::$app->request->get('name');

        $results = $this->actionQueryInfo($this->barcode);
        $this->priceArr = $results;

        $this->actionSave();

        $msg['msg'] = 'success';
        $msg = MethodUtil::var_encode($msg);

        return Json::encode($msg);
    }

    public function actionQueryInfo($id)
    {
        $connection = \Yii::$app->stock2;
        $connection->open();

        $sql = "SELECT GoodsID, Name, BarcodeID FROM Goods WHERE BarcodeID = '" . $id . "'";
        $command = $connection->createCommand($sql);
        $results = $command->queryOne();

        $goodId = $results['GoodsID'];

        \Yii::$app->session['goodsname'] = $results['Name'];
        \Yii::$app->session['goodsbarcode'] = $results['BarcodeID'];

        $this->name = $results['Name'];
        $this->barcode = $results['BarcodeID'];

        $sql1 = "SELECT ShopID, NormalPrice, Price, Flag, PromotionType FROM GoodsShop WHERE GoodsID = '" . $goodId . "' AND ShopID IN('C001','C002','C003','C004','C005','C006','C008','C009','C010','C013','C014','C015','C016','C017','C018','C019','C020','C023','C024','C025','C026')";
        $command1 = $connection->createCommand($sql1);
        $results1 = $command1->queryAll();

        $connection->close();
        $results1 = MethodUtil::var_encode($results1);
        \Yii::$app->session['goodsinfo'] = $results1;

        return $results1;
    }

    public function actionSave()
    {
        $connection = \Yii::$app->market;
        $connection->open();

        $sql = "SELECT id, good_barcode FROM goods WHERE good_barcode = '$this->barcode'";
        $command = $connection->createCommand($sql);
        $results = $command->queryAll();

        $goodsinfo = array();
        foreach ($this->priceArr as $key => $value) {
            $goodsinfo[] = $value['Price'];
        }
        if (count($results) > 0) {
            $sql = "INSERT INTO good_price (good_bar, research_price, c001_price, c002_price, c003_price, c004_price, c005_price, c006_price, c008_price, c009_price, c010_price, c013_price, c014_price, c015_price, c016_price, c017_price, c018_price, c019_price, c020_price, c023_price, c024_price, c025_price, c026_price, comment)
                  VALUES ('$this->barcode', '$this->price', '$goodsinfo[0]', '$goodsinfo[1]', '$goodsinfo[2]', '$goodsinfo[3]', '$goodsinfo[4]', '$goodsinfo[5]', '$goodsinfo[6]', '$goodsinfo[7]', '$goodsinfo[8]', '$goodsinfo[9]', '$goodsinfo[10]', '$goodsinfo[11]', '$goodsinfo[12]', '$goodsinfo[13]', '$goodsinfo[14]', '$goodsinfo[15]', '$goodsinfo[16]', '$goodsinfo[17]', '$goodsinfo[18]', '$goodsinfo[19]', '$goodsinfo[20]', '$this->comment')";
            $command = $connection->createCommand($sql);
            $command->execute();
        } else {
            $sql = "INSERT INTO goods (good_name, good_barcode) VALUES ('$this->name', '$this->barcode')";
            $sql = MethodUtil::var_encode($sql);
            $command = $connection->createCommand($sql);
            $command->execute();
            $sql1 = "INSERT INTO good_price (good_bar, research_price, c001_price, c002_price, c003_price, c004_price, c005_price, c006_price, c008_price, c009_price, c010_price, c013_price, c014_price, c015_price, c016_price, c017_price, c018_price, c019_price, c020_price, c023_price, c024_price, c025_price, c026_price, comment)
                  VALUES ('$this->barcode', '$this->price', '$goodsinfo[0]', '$goodsinfo[1]', '$goodsinfo[2]', '$goodsinfo[3]', '$goodsinfo[4]', '$goodsinfo[5]', '$goodsinfo[6]', '$goodsinfo[7]', '$goodsinfo[8]', '$goodsinfo[9]', '$goodsinfo[10]', '$goodsinfo[11]', '$goodsinfo[12]', '$goodsinfo[13]', '$goodsinfo[14]', '$goodsinfo[15]', '$goodsinfo[16]', '$goodsinfo[17]', '$goodsinfo[18]', '$goodsinfo[19]', '$goodsinfo[20]', '$this->comment')";
            $command1 = $connection->createCommand($sql1);
            $command1->execute();
        }
    }
}