<?php

namespace backend\models;
use yii\db\ActiveRecord;

use Yii;

/**
 * This is the model class for table "bases".
 *
 * @property integer $id_base
 * @property string $nombre_base
 * @property integer $id_fondo
 * @property string $cuerpo_base
 * @property string fecha_creacion_base

 */
class bases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'nombre_base',  'cuerpo_base','fecha_creacion_base'], 'required'],
            [['id_base', 'id_fondo'], 'integer'],
            [['nombre_base', 'cuerpo_base'], 'string'],
            [['fecha_creacion_base'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_base' => 'Id Base',
            'nombre_base'=>'Nombre Base',
            'id_fondo'=> 'Nombre Fondo',
            'cuerpo_base' =>'Cuerpo Base',
            'fecha_creacion_base' =>'Fecha de Creación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondo()
    {
        return $this->hasOne(Fondo::className(), ['id_fondo' => 'id_fondo']);
    }

    public function getBase()
    {
        return $this->hasOne(Fondo::className(), ['id_base' => 'id_base']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuerpoBase()
    {
        return $this->hasOne(User::className(), ['cuerpo_base' => 'cuerpo_base']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuerpoPost()
    {
        return $this->hasOne(User::className(), ['cuerpo_post' => 'cuerpo_post']);
    }


    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    public function getSubString($string, $length=NULL)
    {
        //Si no se especifica la longitud por defecto es 50
        if ($length == NULL)
            $length = 50;
        //Primero eliminamos las etiquetas html y luego cortamos el string
        $stringDisplay = substr(strip_tags($string), 0, $length);
        //Si el texto es mayor que la longitud se agrega puntos suspensivos
        if (strlen(strip_tags($string)) > $length)
            $stringDisplay .= ' ...';
        return $stringDisplay;
    }
}
