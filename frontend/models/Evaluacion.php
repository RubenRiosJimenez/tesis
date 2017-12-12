<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "evaluacion".
 *
 * @property integer $id_evaluacion
 * @property integer $id_postulacion
 * @property integer $id_estado
 * @property integer $etapa
 * @property integer $puntaje_1
 * @property integer $puntaje_2
 * @property integer $puntaje_3
 * @property string $observaciones_1
 * @property string $observaciones_2
 * @property string $observaciones_3
 * @property string $observaciones_4
 *
 * @property Postulacion $idPostulacion
 * @property Estadoevaluacion $idEstado
 * @property Evaluacionarchivo[] $evaluacionarchivos
 */
class Evaluacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_postulacion', 'id_estado', 'etapa', 'puntaje_1', 'puntaje_2', 'puntaje_3'], 'integer'],
            [['observaciones_1', 'observaciones_2', 'observaciones_3'], 'string', 'max' => 500],
            [['id_postulacion'], 'exist', 'skipOnError' => true, 'targetClass' => Postulacion::className(), 'targetAttribute' => ['id_postulacion' => 'id_postulacion']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoevaluacion::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_evaluacion' => 'Id Evaluacion',
            'id_postulacion' => 'Id Postulacion',
            'id_estado' => 'Estado de la evaluación:',
            'etapa' => 'Etapa',
            'puntaje_1' => 'Puntaje:',
            'puntaje_2' => 'Puntaje:',
            'puntaje_3' => 'Puntaje:',
            'observaciones_1' => 'Observaciones:',
            'observaciones_2' => 'Observaciones:',
            'observaciones_3' => 'Observaciones:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPostulacion()
    {
        return $this->hasOne(Postulacion::className(), ['id_postulacion' => 'id_postulacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(Estadoevaluacion::className(), ['id_estado' => 'id_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionarchivos()
    {
        return $this->hasMany(Evaluacionarchivo::className(), ['id_evaluacion' => 'id_evaluacion']);
    }
}
