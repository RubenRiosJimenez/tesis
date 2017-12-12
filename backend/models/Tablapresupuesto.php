<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tablapresupuesto".
 *
 * @property integer $id_tabla_presupuesto
 * @property integer $id_formulario
 * @property string $descripcion
 * @property string $cantidad
 * @property string $precioUnitario
 * @property string $costoTotal
 *
 * @property Formulario $idFormulario
 */
class Tablapresupuesto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tablapresupuesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_formulario'], 'integer'],
            [['descripcion'], 'string', 'max' => 300],
            [['cantidad', 'precioUnitario', 'costoTotal'], 'string', 'max' => 50],
            [['id_formulario'], 'exist', 'skipOnError' => true, 'targetClass' => Formulario::className(), 'targetAttribute' => ['id_formulario' => 'id_formulario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tabla_presupuesto' => 'Id Tabla Presupuesto',
            'id_formulario' => 'Id Formulario',
            'descripcion' => 'Descripcion',
            'cantidad' => 'Cantidad',
            'precioUnitario' => 'Precio Unitario',
            'costoTotal' => 'Costo Total',
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
