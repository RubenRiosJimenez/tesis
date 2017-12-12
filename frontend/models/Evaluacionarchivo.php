<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "evaluacionarchivo".
 *
 * @property integer $id_evaluacionArchivo
 * @property integer $id_evaluacion
 * @property integer $id_tipoArchivo
 * @property string $observaciones
 * @property integer $id_estado
 *
 * @property Evaluacion $idEvaluacion
 * @property Tipoarchivo $idTipoArchivo
 * @property Estadoevaluacionarchivo $idEstado
 */
class Evaluacionarchivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacionarchivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estado'], 'required'],
            [['id_evaluacion', 'id_tipoArchivo', 'id_estado'], 'integer'],
            [['observaciones'], 'string', 'max' => 500],
            [['id_evaluacion'], 'exist', 'skipOnError' => true, 'targetClass' => Evaluacion::className(), 'targetAttribute' => ['id_evaluacion' => 'id_evaluacion']],
            [['id_tipoArchivo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoarchivo::className(), 'targetAttribute' => ['id_tipoArchivo' => 'id_tipoArchivo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoevaluacionarchivo::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evaluacionArchivo' => 'Id Evaluacion Archivo',
            'id_evaluacion' => 'Id Evaluacion',
            'id_tipoArchivo' => 'Id Tipo Archivo',
            'observaciones' => 'Observaciones:',
            'id_estado' => 'Estado del documento:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvaluacion()
    {
        return $this->hasOne(Evaluacion::className(), ['id_evaluacion' => 'id_evaluacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoArchivo()
    {
        return $this->hasOne(Tipoarchivo::className(), ['id_tipoArchivo' => 'id_tipoArchivo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(Estadoevaluacionarchivo::className(), ['id_estado' => 'id_estado']);
    }
}
