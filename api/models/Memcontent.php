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
            'uid' => 'Uid',
            'idc_name' => 'Idc Name',
            'idc_sex' => 'Idc Sex',
            'idc_nation' => 'Idc Nation',
            'idc_birth' => 'Idc Birth',
            'idc_address' => 'Idc Address',
            'idc_id' => 'Idc ID',
            'idc_start' => 'Idc Start',
            'idc_end' => 'Idc End',
            'idc_dep' => 'Idc Dep',
            'phonenumber' => 'Phonenumber',
            'mem_number' => 'Mem Number',
            's_id' => 'S ID',
            'r_id' => 'R ID',
            'u_id' => 'U ID',
            'inputtime' => 'Inputtime',
            'registration' => 'Registration',
            'addtime' => 'Addtime',
            'id' => 'ID',
        ];
    }
}
