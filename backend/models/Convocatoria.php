<?php

namespace backend\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "convocatoria".
 *
 * @property integer $id_convocatoria
 * @property integer $id_estadoConvocatoria
 * @property string $nombreConvocatoria
 * @property string $fecha_inicio
 * @property string $fecha_termino
 * @property int $id_fondo

 *
 * @property Estadoconvocatoria $idEstadoConvocatoria
 * @property Postulacion[] $postulacions
 */
class Convocatoria extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'convocatoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['montoConvocatoria'], 'number', 'min' => 0, 'max' => 100000000000],
            [['nombreConvocatoria','fecha_inicio','fecha_termino','montoConvocatoria','id_fondo'], 'required'],
            [['id_estadoConvocatoria','montoConvocatoria'], 'integer'],
            [['fecha_inicio', 'fecha_termino'], 'safe'],
            [['nombreConvocatoria'], 'string', 'max' => 80],
            [['observacion'], 'string', 'max' => 500],
            [['id_estadoConvocatoria'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoconvocatoria::className(), 'targetAttribute' => ['id_estadoConvocatoria' => 'id_estadoConvocatoria']],
            [['id_fondo'], 'exist', 'skipOnError' => true, 'targetClass' => fondo::className(), 'targetAttribute' => ['id_fondo' => 'id_fondo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_convocatoria' => 'Id Convocatoria',
            'id_estadoConvocatoria' => 'Estado de la convocatoria:',
            'nombreConvocatoria' => 'Nombre de la convocatoria:',
            'montoConvocatoria' => 'Monto total de la subvención ($):',            
            'fecha_inicio' => 'Fecha de inicio:',
            'fecha_termino' => 'Fecha de término:',
            'observacion' => 'Observaciones: (Opcional)',
            'id_fondo' => 'Seleccionar Fondo'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getestadoconvocatoria()
    {
        return $this->hasOne(Estadoconvocatoria::className(), ['id_estadoConvocatoria' => 'id_estadoConvocatoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacions()
    {
        return $this->hasMany(Postulacion::className(), ['id_convocatoria' => 'id_convocatoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondo()
    {
        return $this->hasOne(Fondo::className(), ['id_fondo' => 'id_fondo']);
    }
}
