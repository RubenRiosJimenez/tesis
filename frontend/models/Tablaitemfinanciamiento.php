<?php

namespace frontend\models;

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
            [['descripcion','monto'], 'required'],        
            [['id_formulario','monto'], 'integer'],
            [['monto'], 'number','min' => 0, 'max' => 100000000000],
            [['descripcion'], 'string', 'max' => 80],
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
            'descripcion' => 'Descripción:',
            'monto' => 'Monto ($):',
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
