<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Concursante;

/**
 * ConcursanteSearch represents the model behind the search form about `frontend\models\Concursante`.
 */
class ConcursanteSearch extends Concursante
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_concursante', 'id_tipoConcursante', 'id','montoConvocatoria'], 'integer'],
            [['nombreConcursante', 'rut', 'domicilio', 'telefono'], 'safe'],
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
        $query = Concursante::find();

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
            'id_concursante' => $this->id_concursante,
            'id_tipoConcursante' => $this->id_tipoConcursante,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'nombreConcursante', $this->nombreConcursante])
            ->andFilterWhere(['like', 'rut', $this->rut])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'montoConvocatoria', $this->montoConvocatoria]);
        return $dataProvider;
    }
}
