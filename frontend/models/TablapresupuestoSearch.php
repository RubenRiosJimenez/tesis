<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tablapresupuesto;

/**
 * TablapresupuestoSearch represents the model behind the search form about `frontend\models\Tablapresupuesto`.
 */
class TablapresupuestoSearch extends Tablapresupuesto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tabla_presupuesto', 'id_formulario'], 'integer'],
            [['descripcion', 'cantidad', 'precioUnitario', 'costoTotal'], 'safe'],
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
        $query = Tablapresupuesto::find();

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
            'id_tabla_presupuesto' => $this->id_tabla_presupuesto,
            'id_formulario' => $this->id_formulario,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'cantidad', $this->cantidad])
            ->andFilterWhere(['like', 'precioUnitario', $this->precioUnitario])
            ->andFilterWhere(['like', 'costoTotal', $this->costoTotal]);

        return $dataProvider;
    }
}
