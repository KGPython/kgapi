<?php

namespace api\models;

/**
 * This is the ActiveQuery class for [[MemberRole]].
 *
 * @see MemberRole
 */
class MemberRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MemberRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MemberRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
