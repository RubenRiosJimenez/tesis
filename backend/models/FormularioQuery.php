<?php

namespace backend\models;
/**
 * This is the ActiveQuery class for [[Formulario]].
 *
 * @see Formulario
 */
class FormularioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Formulario[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Formulario|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
