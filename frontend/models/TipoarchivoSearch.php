<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tipoarchivo;

/**
 * TipoarchivoSearch represents the model behind the search form about `frontend\models\Tipoarchivo`.
 */
class TipoarchivoSearch extends Tipoarchivo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipoArchivo'], 'integer'],
            [['nombre_tipoArchivo'], 'safe'],
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
        $query = Tipoarchivo::find();

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
            'id_tipoArchivo' => $this->id_tipoArchivo,
        ]);

        $query->andFilterWhere(['like', 'nombre_tipoArchivo', $this->nombre_tipoArchivo]);

        return $dataProvider;
    }
}
