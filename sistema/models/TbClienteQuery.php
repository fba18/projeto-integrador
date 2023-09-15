<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TbCliente]].
 *
 * @see TbCliente
 */
class TbClienteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TbCliente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbCliente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
