<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_member_auxiliary".
 *
 * @property string $id
 * @property string $member_id
 * @property integer $member_type
 * @property integer $member_level
 * @property string $default_shop
 */
class MemberAuxiliary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wap_member_auxiliary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'member_type', 'member_level'], 'integer'],
            [['default_shop'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('api', 'ID'),
            'member_id' => Yii::t('api', '会员ID'),
            'member_type' => Yii::t('api', '会员类型'),
            'member_level' => Yii::t('api', '会员等级'),
            'default_shop' => Yii::t('api', '默认门店'),
            'member_url' => Yii::t('api', '电子会员卡'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberAuxiliaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberAuxiliaryQuery(get_called_class());
    }
}
