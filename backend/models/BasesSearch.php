<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\bases;

/**
 * BasesSearch represents the model behind the search form about `app\models\bases`.
 */
class BasesSearch extends bases
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_base', 'id_fondo'], 'integer'],
            [['nombre_base', 'cuerpo_base'], 'safe'],
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
        $query = bases::find();

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
            'id_base' => $this->id_base,
            'id_fondo' => $this->id_fondo,
        ]);

        $query->andFilterWhere(['like', 'nombre_base', $this->nombre_base])
            ->andFilterWhere(['like', 'cuerpo_base', $this->cuerpo_base]);

        return $dataProvider;
    }
}
