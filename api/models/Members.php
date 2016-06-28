<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "uc_members".
 *
 * @property string $uid
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $myid
 * @property string $myidkey
 * @property string $regip
 * @property string $regdate
 * @property integer $lastloginip
 * @property string $lastlogintime
 * @property string $salt
 * @property string $secques
 */
class Members extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uc_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'myid', 'myidkey', 'regip', 'salt', 'secques'], 'required'],
            [['regdate', 'lastloginip', 'lastlogintime'], 'integer'],
            [['username', 'regip'], 'string', 'max' => 15],
            [['password', 'email'], 'string', 'max' => 32],
            [['myid'], 'string', 'max' => 30],
            [['myidkey'], 'string', 'max' => 16],
            [['salt'], 'string', 'max' => 6],
            [['secques'], 'string', 'max' => 8],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => Yii::t('api', 'Uid'),
            'username' => Yii::t('api', 'Username'),
            'password' => Yii::t('api', 'Password'),
            'email' => Yii::t('api', 'Email'),
            'myid' => Yii::t('api', 'Myid'),
            'myidkey' => Yii::t('api', 'Myidkey'),
            'regip' => Yii::t('api', 'Regip'),
            'regdate' => Yii::t('api', 'Regdate'),
            'lastloginip' => Yii::t('api', 'Lastloginip'),
            'lastlogintime' => Yii::t('api', 'Lastlogintime'),
            'salt' => Yii::t('api', 'Salt'),
            'secques' => Yii::t('api', 'Secques'),
        ];
    }

    /**
     * @inheritdoc
     * @return MembersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MembersQuery(get_called_class());
    }
}
