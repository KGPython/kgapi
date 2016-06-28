<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_role".
 *
 * @property string $id
 * @property string $name
 * @property integer $seq
 * @property string $description
 * @property integer $isdefault
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wap_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['seq', 'isdefault'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('api', 'ID'),
            'name' => Yii::t('api', 'Name'),
            'seq' => Yii::t('api', 'Seq'),
            'description' => Yii::t('api', 'Description'),
            'isdefault' => Yii::t('api', 'Isdefault'),
        ];
    }

    /**
     * @inheritdoc
     * @return RoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleQuery(get_called_class());
    }
}
