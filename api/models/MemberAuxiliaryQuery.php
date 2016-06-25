<?php

namespace api\models;

/**
 * This is the ActiveQuery class for [[MemberAuxiliary]].
 *
 * @see MemberAuxiliary
 */
class MemberAuxiliaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MemberAuxiliary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MemberAuxiliary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
