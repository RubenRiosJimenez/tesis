<?php

namespace frontend\models;
use Yii;

/**
 * This is the model class for table "tipoconcursante".
 *
 * @property integer $id_tipoConcursante
 * @property string $nombreTipo
 *
 * @property Concursante[] $concursantes
 */
class Tipoconcursante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoconcursante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreTipo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipoConcursante' => 'Id Tipo Concursante',
            'nombreTipo' => 'Nombre Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConcursantes()
    {
        return $this->hasMany(Concursante::className(), ['id_tipoConcursante' => 'id_tipoConcursante']);
    }
}
