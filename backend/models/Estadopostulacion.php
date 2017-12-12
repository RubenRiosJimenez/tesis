<?php

namespace backend\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "estadopostulacion".
 *
 * @property integer $id_estadopostulacion
 * @property string $nombre_estadopostulacion
 *
 * @property Postulacion[] $postulacions
 */
class Estadopostulacion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadopostulacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_estadopostulacion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estadopostulacion' => 'Id Estadopostulacion',
            'nombre_estadopostulacion' => 'Estado de la postulación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacions()
    {
        return $this->hasMany(Postulacion::className(), ['id_estadopostulacion' => 'id_estadopostulacion']);
    }
}
