<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_member_role".
 *
 * @property string $id
 * @property string $member_id
 * @property string $role_id
 */
class MemberRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wap_member_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'role_id'], 'required'],
            [['member_id', 'role_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('api', 'ID'),
            'member_id' => Yii::t('api', 'Member ID'),
            'role_id' => Yii::t('api', 'Role ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return MemberRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemberRoleQuery(get_called_class());
    }
}
