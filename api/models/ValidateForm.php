<?php
/**
 * Created by PhpStorm.
 * User: End
 * Date: 2016/7/4
 * Time: 17:02
 */
namespace api\models;

use Yii\db\ActiveRecord;

class ValidateForm extends ActiveRecord
{
    public function rules()
    {
        return [
            [['GoodsName', 'GoodsBarcode', 'GoodPrice'], 'required', 'trim'],
            ['GoodsName', 'string'],
            ['GoodsBarcode', 'integer'],
            ['GoodPrice', 'number']
        ];
    }
}