<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "fondo".
 *
 * @property integer $id_fondo
 * @property string $nombre_fondo
 * @property string $nombre_estado
 * @property string $observacion_fondo
 * @property string $fecha_creacion
 */
class Fondo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fondo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_fondo',  'observacion_fondo', 'fecha_creacion','nombre_estado'], 'required'],
            [['observacion_fondo'], 'string'],
            [['fecha_creacion'], 'safe'],
            [['nombre_fondo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_fondo' => 'Id Fondo',
            'nombre_fondo' => 'Nombre Fondo',
            'nombre_estado' => 'Estado Fondo',
            'observacion_fondo' => 'Observación',
            'fecha_creacion' => 'Fecha de Creación',
        ];
    }
}
