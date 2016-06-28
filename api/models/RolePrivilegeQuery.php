<?php

namespace api\models;

/**
 * This is the ActiveQuery class for [[RolePrivilege]].
 *
 * @see RolePrivilege
 */
class RolePrivilegeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RolePrivilege[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RolePrivilege|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
