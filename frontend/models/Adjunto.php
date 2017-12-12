<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "adjunto".
 *
 * @property integer $id_adjunto
 * @property integer $id_formulario
 * @property integer $id_tipoArchivo
 * @property string $nombre_archivo
 * @property string $nombre_original
 * @property string $fecha_subida
 *
 * @property Formulario $idFormulario
 * @property Tipoarchivo $idTipoArchivo
 */
class Adjunto extends \yii\db\ActiveRecord
{

    public $archivo;
    public $fileName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adjunto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_formulario', 'id_tipoArchivo'], 'integer'],
            [['fecha_subida'], 'safe'],
            [['nombre_archivo', 'nombre_original'], 'string', 'max' => 300],
            [['id_formulario'], 'exist', 'skipOnError' => true, 'targetClass' => Formulario::className(), 'targetAttribute' => ['id_formulario' => 'id_formulario']],
            [['id_tipoArchivo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoarchivo::className(), 'targetAttribute' => ['id_tipoArchivo' => 'id_tipoArchivo']],
            [['archivo'],'safe'],
            [['archivo'],'file','extensions' => 'jpg, gif, png, bmp, jpeg, jpe, pptx, xlsx, pdf, docx, doc, ppt, xls'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_adjunto' => 'Id Adjunto',
            'id_formulario' => 'Id Formulario',
            'id_tipoArchivo' => 'Id Tipo Archivo',
            'nombre_archivo' => 'Nombre Archivo',
            'nombre_original' => 'Nombre Original',
            'fecha_subida' => 'Fecha Subida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFormulario()
    {
        return $this->hasOne(Formulario::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoArchivo()
    {
        return $this->hasOne(Tipoarchivo::className(), ['id_tipoArchivo' => 'id_tipoArchivo']);
    }
    public function getArchivo(){
        return isset($this->nombre_archivo)?'uploads/'.$this->nombre_archivo:null;
    }  
}
