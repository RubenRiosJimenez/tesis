<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Fondo;

/**
 * FondoSearch represents the model behind the search form about `backend\models\Fondo`.
 */
class FondoSearch extends Fondo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fondo'], 'integer'],
            [['nombre_fondo', 'nombre_estado', 'observacion_fondo', 'fecha_creacion'], 'safe'],
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
        $query = Fondo::find();

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
            'id_fondo' => $this->id_fondo,
            'fecha_creacion' => $this->fecha_creacion,
        ]);

        $query->andFilterWhere(['like', 'nombre_fondo', $this->nombre_fondo])
            ->andFilterWhere(['like', 'nombre_estado', $this->nombre_estado])
            ->andFilterWhere(['like', 'fecha_creacion', $this->fecha_creacion])
            ->andFilterWhere(['like', 'observacion_fondo', $this->observacion_fondo]);

        return $dataProvider;
    }
}
