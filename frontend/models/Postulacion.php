<?php


namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "postulacion".
 *
 * @property integer $id_postulacion
 * @property integer $id_convocatoria
 * @property integer $id_concursante
 * @property integer $id_resultado
 * @property integer $id_estadopostulacion
 * @property string $fecha_postulacion
 *
 * @property Formulario[] $formularios
 * @property Convocatoria $idConvocatoria
 * @property Concursante $idConcursante
 * @property Estadopostulacion $idEstadopostulacion
 * @property Resultado $idResultado
 */
class Postulacion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postulacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['montoAsignado'], 'safe'],
            [['id_convocatoria', 'id_concursante', 'id_estadopostulacion'], 'integer'],
            [['fecha_postulacion'], 'safe'],
            [['id_convocatoria'], 'exist', 'skipOnError' => true, 'targetClass' => Convocatoria::className(), 'targetAttribute' => ['id_convocatoria' => 'id_convocatoria']],
            [['id_concursante'], 'exist', 'skipOnError' => true, 'targetClass' => Concursante::className(), 'targetAttribute' => ['id_concursante' => 'id_concursante']],
            [['id_estadopostulacion'], 'exist', 'skipOnError' => true, 'targetClass' => Estadopostulacion::className(), 'targetAttribute' => ['id_estadopostulacion' => 'id_estadopostulacion']],
        ];
    }

 

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_postulacion' => 'Id Postulacion',
            'id_convocatoria' => 'Id Convocatoria',
            'id_concursante' => 'Id Concursante',
            'id_estadopostulacion' => 'Id Estadopostulacion',
            'montoAsignado' => 'monto asignado ($)',
            'fecha_postulacion' => 'Fecha Postulacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormularios()
    {
        return $this->hasMany(Formulario::className(), ['id_postulacion' => 'id_postulacion']);
    }

    public function getformulario()
    {
        return $this->hasOne(Formulario::className(), ['id_postulacion' => 'id_postulacion']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getconvocatoria()
    {
        return $this->hasOne(Convocatoria::className(), ['id_convocatoria' => 'id_convocatoria']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFondo()
    {
        return $this->hasOne(Convocatoria::className(), ['id_fondo' => 'id_fondo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getconcursante()
    {
        return $this->hasOne(Concursante::className(), ['id_concursante' => 'id_concursante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getestadopostulacion()
    {
        return $this->hasOne(Estadopostulacion::className(), ['id_estadopostulacion' => 'id_estadopostulacion']);
    }

    public function getevaluacion()
    {
        return $this->hasOne(Evaluacion::className(), ['id_postulacion' => 'id_postulacion']);
    }  

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @inheritdoc
     * @return PostulacionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostulacionQuery(get_called_class());
    }
}
