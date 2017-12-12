<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_post".
 *
 * @property integer $id_tipoPost
 * @property string $nombre_tipoPost
 *
 * @property Post $post
 */
class TipoPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipoPost', 'nombre_tipoPost'], 'required'],
            [['id_tipoPost'], 'integer'],
            [['nombre_tipoPost'], 'string', 'max' => 115],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipoPost' => Yii::t('app', 'Id Tipo Post'),
            'nombre_tipoPost' => Yii::t('app', 'Nombre Tipo Post'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id_post' => 'id_tipoPost']);
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }
}
