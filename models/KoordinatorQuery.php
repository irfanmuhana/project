<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Koordinator]].
 *
 * @see Koordinator
 */
class KoordinatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Koordinator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Koordinator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
