<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tablaitemfinanciamiento;

/**
 * TablaitemfinanciamientoSearch represents the model behind the search form about `frontend\models\Tablaitemfinanciamiento`.
 */
class TablaitemfinanciamientoSearch extends Tablaitemfinanciamiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tabla_item_financiamiento', 'id_formulario'], 'integer'],
            [['descripcion', 'monto'], 'safe'],
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
        $query = Tablaitemfinanciamiento::find();

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
            'id_tabla_item_financiamiento' => $this->id_tabla_item_financiamiento,
            'id_formulario' => $this->id_formulario,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'monto', $this->monto]);

        return $dataProvider;
    }
}
