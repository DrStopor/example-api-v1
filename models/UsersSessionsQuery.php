<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UsersSessions]].
 *
 * @see UsersSessions
 */
class UsersSessionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UsersSessions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UsersSessions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
