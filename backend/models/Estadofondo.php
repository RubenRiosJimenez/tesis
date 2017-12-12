<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadofondo".
 *
 * @property integer $id_estadoFondo
 * @property string $nombre_estado
 */
class Estadofondo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadofondo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estadoFondo'], 'required'],
            [['id_estadoFondo'], 'integer'],
            [['nombre_estado'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estadoFondo' => Yii::t('app', 'Id Estado Fondo'),
            'nombre_estado' => Yii::t('app', 'Nombre Estado'),
        ];
    }
}
