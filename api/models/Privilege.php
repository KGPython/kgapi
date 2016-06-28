<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_privilege".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $icon
 * @property integer $pid
 * @property integer $seq
 * @property integer $state
 * @property integer $privilegetype
 * @property string $createtime
 */
class Privilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wap_privilege';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'pid', 'seq', 'state', 'privilegetype'], 'integer'],
            [['createtime'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['url'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['icon'], 'string', 'max' => 32],
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
            'url' => Yii::t('api', 'Url'),
            'description' => Yii::t('api', 'Description'),
            'icon' => Yii::t('api', 'Icon'),
            'pid' => Yii::t('api', 'Pid'),
            'seq' => Yii::t('api', 'Seq'),
            'state' => Yii::t('api', 'State'),
            'privilegetype' => Yii::t('api', 'Privilegetype'),
            'createtime' => Yii::t('api', 'Createtime'),
        ];
    }

    /**
     * @inheritdoc
     * @return PrivilegeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrivilegeQuery(get_called_class());
    }
}
