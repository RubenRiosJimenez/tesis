<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "estadoconvocatoria".
 *
 * @property integer $id_estadoConvocatoria
 * @property string $nombre_estado
 *
 * @property Convocatoria[] $convocatorias
 */
class Estadoconvocatoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadoconvocatoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_estado'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estadoConvocatoria' => 'Id Estado Convocatoria',
            'nombre_estado' => 'Nombre Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvocatorias()
    {
        return $this->hasMany(Convocatoria::className(), ['id_estadoConvocatoria' => 'id_estadoConvocatoria']);
    }
}
