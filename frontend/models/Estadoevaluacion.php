<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "estadoevaluacion".
 *
 * @property integer $id_estado
 * @property string $descripcion_estado
 *
 * @property Evaluacion[] $evaluacions
 */
class Estadoevaluacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadoevaluacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_estado'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estado' => 'Id Estado',
            'descripcion_estado' => 'Descripcion Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacions()
    {
        return $this->hasMany(Evaluacion::className(), ['id_estado' => 'id_estado']);
    }
}
