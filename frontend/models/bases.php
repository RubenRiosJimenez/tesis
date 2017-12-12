<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bases".
 *
 * @property integer $id_base
 * @property string $nombre_base
 * @property integer $id_fondo
 * @property string $cuerpo_base
 * @property string $fecha_creacion_base
 */
class bases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_base', 'id_fondo', 'cuerpo_base'], 'required'],
            [['nombre_base', 'cuerpo_base'], 'string'],
            [['id_fondo'], 'integer'],
            [['fecha_creacion_base'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_base' => Yii::t('app', 'Id Base'),
            'nombre_base' => Yii::t('app', 'Nombre Base'),
            'id_fondo' => Yii::t('app', 'Id Fondo'),
            'cuerpo_base' => Yii::t('app', 'Cuerpo Base'),
            'fecha_creacion_base' => Yii::t('app', 'Fecha Creacion Base'),
        ];
    }
}
