<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id_post
 * @property integer $id
 * @property string $titulo_post
 * @property string $cuerpo_post
 * @property string $fecha_creacion_post
 * @property string $imagen_Post
 * @property integer $id_fondo
 *
 * @property Fondo $idFondo
 * @property User $id0
 * @property TipoPost $idPost
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_fondo'], 'integer'],
            [['cuerpo_post'], 'string'],
            [['fecha_creacion_post'], 'safe'],
            [['id_fondo','titulo_post','id_tipoPost','cuerpo_post'], 'required'],
            [['imagen_Post'], 'string'],
            [['titulo_post', 'imagen_Post'], 'string', 'max' => 255],
            [['id_fondo'], 'exist', 'skipOnError' => true, 'targetClass' => Fondo::className(), 'targetAttribute' => ['id_fondo' => 'id_fondo']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
            [['id_tipoPost'], 'exist', 'skipOnError' => true, 'targetClass' => TipoPost::className(), 'targetAttribute' => ['id_tipoPost' => 'id_tipoPost']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_post' => Yii::t('app', 'Id Post'),
            'id' => Yii::t('app', 'ID'),
            'titulo_post' => Yii::t('app', 'Titulo Publicación'),
            'cuerpo_post' => Yii::t('app', 'Cuerpo Publicación'),
            'fecha_creacion_post' => Yii::t('app', 'Fecha Creacion Publicación'),
            'imagen_Post' => Yii::t('app', 'Imagen  Publicación'),
            'id_fondo' => Yii::t('app', 'Nombre Fondo'),
            'id_tipoPost' => Yii::t('app', 'Tipo Publicación'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFondo()
    {
        return $this->hasOne(Fondo::className(), ['id_fondo' => 'id_fondo']);
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
    public function getIdPost()
    {
        return $this->hasOne(TipoPost::className(), ['id_tipoPost' => 'id_post']);
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
