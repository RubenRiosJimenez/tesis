<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipoarchivo".
 *
 * @property integer $id_tipoArchivo
 * @property string $nombre_tipoArchivo
 *
 * @property Adjunto[] $adjuntos
 */
class Tipoarchivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoarchivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_tipoArchivo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipoArchivo' => 'Id Tipo Archivo',
            'nombre_tipoArchivo' => 'Nombre Tipo Archivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntos()
    {
        return $this->hasMany(Adjunto::className(), ['id_tipoArchivo' => 'id_tipoArchivo']);
    }
}
