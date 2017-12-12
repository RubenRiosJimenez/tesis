<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tablaitemfinanciamiento".
 *
 * @property integer $id_tabla_item_financiamiento
 * @property integer $id_formulario
 * @property string $descripcion
 * @property string $monto
 *
 * @property Formulario $idFormulario
 */
class Tablaitemfinanciamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tablaitemfinanciamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_formulario'], 'integer'],
            [['descripcion'], 'string', 'max' => 300],
            [['monto'], 'string', 'max' => 50],
            [['id_formulario'], 'exist', 'skipOnError' => true, 'targetClass' => Formulario::className(), 'targetAttribute' => ['id_formulario' => 'id_formulario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tabla_item_financiamiento' => 'Id Tabla Item Financiamiento',
            'id_formulario' => 'Id Formulario',
            'descripcion' => 'Descripcion',
            'monto' => 'Monto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFormulario()
    {
        return $this->hasOne(Formulario::className(), ['id_formulario' => 'id_formulario']);
    }
}
