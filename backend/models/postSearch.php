<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\post;

/**
 * postSearch represents the model behind the search form about `backend\models\post`.
 */
class postSearch extends post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_post', 'id', 'id_fondo'], 'integer'],
            [['titulo_post', 'cuerpo_post', 'fecha_creacion_post', 'imagen_Post'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_post' => $this->id_post,
            'id' => $this->id,
            'fecha_creacion_post' => $this->fecha_creacion_post,
            'id_fondo' => $this->id_fondo,
        ]);

        $query->andFilterWhere(['like', 'titulo_post', $this->titulo_post])
            ->andFilterWhere(['like', 'cuerpo_post', $this->cuerpo_post])
            ->andFilterWhere(['like', 'imagen_Post', $this->imagen_Post]);

        return $dataProvider;
    }
}
