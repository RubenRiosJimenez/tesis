<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "areasubvencion".
 *
 * @property integer $id_areaSubvencion
 * @property string $nombre_area
 *
 * @property Formulario[] $formularios
 */
class Areasubvencion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areasubvencion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_area'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_areaSubvencion' => 'Id Area Subvencion',
            'nombre_area' => 'Nombre Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormularios()
    {
        return $this->hasMany(Formulario::className(), ['id_areaSubvencion' => 'id_areaSubvencion']);
    }
}
