<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estadoresultado".
 *
 * @property integer $id_estado
 * @property string $descripcion_estado
 *
 * @property Resultado[] $resultados
 */
class Estadoresultado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadoresultado';
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
    public function getResultados()
    {
        return $this->hasMany(Resultado::className(), ['id_estado' => 'id_estado']);
    }
}
