<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "estadoevaluacionarchivo".
 *
 * @property integer $id_estado
 * @property string $descripcion_estado
 *
 * @property Evaluacionarchivo[] $evaluacionarchivos
 */
class Estadoevaluacionarchivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadoevaluacionarchivo';
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
    public function getEvaluacionarchivos()
    {
        return $this->hasMany(Evaluacionarchivo::className(), ['id_estado' => 'id_estado']);
    }
}
