<?php

namespace api\models;

/**
 * This is the ActiveQuery class for [[Memcontent]].
 *
 * @see Memcontent
 */
class MemcontentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Memcontent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Memcontent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
