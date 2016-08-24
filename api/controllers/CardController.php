<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/24
 * Time: 9:35
 */

namespace api\controllers;
use yii\web\Controller;

class CardController extends Controller
{
    public function actionBalance($cardno,$secrety){
        $conn = \Yii::$app->card;
        $conn->open();
        $sql = "select cardno,detail from guest where cardno='".$cardno."' and secrety='".$secrety."' ";
        $comm = $conn->createCommand($sql);
        $res = $comm->queryOne();
        var_dump($res);
    }

}