<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Postulacion]].
 *
 * @see Postulacion
 */
class PostulacionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Postulacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Postulacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
