<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_role_privilege".
 *
 * @property string $id
 * @property string $role_id
 * @property string $privilege_id
 */
class RolePrivilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wap_role_privilege';
    }

    public function getPrivileges()
    {
        return $this->hasMany(Privilege::className(), ['id' => 'privilege_id']);
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(),['id'=>'role_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'privilege_id'], 'required'],
            [['role_id', 'privilege_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('api', 'ID'),
            'role_id' => Yii::t('api', 'Role ID'),
            'privilege_id' => Yii::t('api', 'Privilege ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return RolePrivilegeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RolePrivilegeQuery(get_called_class());
    }
}
