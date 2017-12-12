<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tipoconcursante;

/**
 * TipoconcursanteSearch represents the model behind the search form about `backend\models\Tipoconcursante`.
 */
class TipoconcursanteSearch extends Tipoconcursante
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipoConcursante'], 'integer'],
            [['nombreTipo'], 'safe'],
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
        $query = Tipoconcursante::find();

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
            'id_tipoConcursante' => $this->id_tipoConcursante,
        ]);

        $query->andFilterWhere(['like', 'nombreTipo', $this->nombreTipo]);

        return $dataProvider;
    }
}
