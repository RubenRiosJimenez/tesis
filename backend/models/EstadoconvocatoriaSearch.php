<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Estadoconvocatoria;

/**
 * EstadoconvocatoriaSearch represents the model behind the search form about `frontend\models\Estadoconvocatoria`.
 */
class EstadoconvocatoriaSearch extends Estadoconvocatoria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estadoConvocatoria'], 'integer'],
            [['nombre_estado'], 'safe'],
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
        $query = Estadoconvocatoria::find();

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
            'id_estadoConvocatoria' => $this->id_estadoConvocatoria,
        ]);

        $query->andFilterWhere(['like', 'nombre_estado', $this->nombre_estado]);

        return $dataProvider;
    }
}
