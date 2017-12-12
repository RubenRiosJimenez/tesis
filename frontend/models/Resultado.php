<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "resultado".
 *
 * @property integer $id_resultado
 * @property integer $id_evaluacion
 * @property integer $id_estado
 * @property string $montoAsignado
 * @property string $observaciones
 *
 * @property Evaluacion $idEvaluacion
 * @property Estadoresultado $idEstado
 */
class Resultado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_evaluacion', 'id_estado'], 'integer'],
            [['observaciones'], 'string', 'max' => 500],
            [['id_evaluacion'], 'exist', 'skipOnError' => true, 'targetClass' => Evaluacion::className(), 'targetAttribute' => ['id_evaluacion' => 'id_evaluacion']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoresultado::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_resultado' => 'Id Resultado',
            'id_evaluacion' => 'Id Evaluacion',
            'id_estado' => 'Resultado de la asignación:',
            'observaciones' => 'Observaciones',
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
    public function getIdEstado()
    {
        return $this->hasOne(Estadoresultado::className(), ['id_estado' => 'id_estado']);
    }
}
