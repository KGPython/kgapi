<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_memcontent".
 *
 * @property string $uid
 * @property string $idc_name
 * @property string $idc_sex
 * @property string $idc_nation
 * @property string $idc_birth
 * @property string $idc_address
 * @property string $idc_id
 * @property string $idc_start
 * @property string $idc_end
 * @property string $idc_dep
 * @property string $phonenumber
 * @property string $mem_number
 * @property string $s_id
 * @property string $r_id
 * @property string $u_id
 * @property string $inputtime
 * @property string $registration
 * @property string $addtime
 * @property integer $id
 */
class Memcontent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uc_memcontent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['addtime'], 'safe'],
            [['uid', 'idc_nation'], 'string', 'max' => 10],
            [['idc_name', 'idc_dep'], 'string', 'max' => 30],
            [['idc_sex'], 'string', 'max' => 5],
            [['idc_birth', 'idc_start', 'idc_end'], 'string', 'max' => 8],
            [['idc_address'], 'string', 'max' => 70],
            [['idc_id'], 'string', 'max' => 18],
            [['phonenumber'], 'string', 'max' => 11],
            [['mem_number'], 'string', 'max' => 20],
            [['s_id', 'r_id', 'u_id'], 'string', 'max' => 4],
            [['inputtime', 'registration'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => Yii::t('api', '会员ID'),
            'idc_name' => Yii::t('api', '姓名'),
            'idc_sex' => Yii::t('api', '性别'),
            'idc_nation' => Yii::t('api', '民族'),
            'idc_birth' => Yii::t('api', '出生日期'),
            'idc_address' => Yii::t('api', '住址'),
            'idc_id' => Yii::t('api', '身份证号'),
            'idc_start' => Yii::t('api', '证件起始时间'),
            'idc_end' => Yii::t('api', '证件失效时间'),
            'idc_dep' => Yii::t('api', '签发机构'),
            'phonenumber' => Yii::t('api', '会员手机号'),
            'mem_number' => Yii::t('api', '会员卡号'),
            's_id' => Yii::t('api', '门店'),
            'r_id' => Yii::t('api', 'R ID'),
            'u_id' => Yii::t('api', 'U ID'),
            'inputtime' => Yii::t('api', '数据录入时间'),
            'registration' => Yii::t('api', '注册时间'),
            'addtime' => Yii::t('api', '创建时间'),
            'id' => Yii::t('api', 'ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemcontentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemcontentQuery(get_called_class());
    }
}
