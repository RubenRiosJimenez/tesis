<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tablacartagantt".
 *
 * @property integer $id_tabla_cartaGantt
 * @property integer $id_formulario
 * @property string $mes
 * @property string $descripcion
 *
 * @property Formulario $idFormulario
 */
class Tablacartagantt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tablacartagantt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['mes'], 'unique'],
            [['mes','descripcion'], 'required'],        
            [['id_formulario'], 'integer'],
            [['mes'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 130],
            [['id_formulario'], 'exist', 'skipOnError' => true, 'targetClass' => Formulario::className(), 'targetAttribute' => ['id_formulario' => 'id_formulario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tabla_cartaGantt' => 'Id Tabla Carta Gantt',
            'id_formulario' => 'Id Formulario',
            'mes' => 'Mes:',
            'descripcion' => 'Descripción:',
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
