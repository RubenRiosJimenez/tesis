<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Convocatoria;

/**
 * ConvocatoriaSearch represents the model behind the search form about `frontend\models\Convocatoria`.
 */
class ConvocatoriaSearch extends Convocatoria
{
    /**
     * @inheritdoc
     */

    public $estadoconvocatoria;

    public function rules()
    {
        return [
            [['id_convocatoria', 'id_estadoConvocatoria'], 'integer'],
            [['nombreConvocatoria', 'fecha_inicio', 'fecha_termino','observacion'], 'safe'],
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
        $query = Convocatoria::find();
        $query->joinWith(['estadoconvocatoria']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['estadoconvocatoria'] = [
            'asc' => ['estadoconvocatoria.nombre_estado' => SORT_ASC],
            'desc' => ['estadoconvocatoria.nombre_estado' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'convocatoria.id_convocatoria' => $this->id_convocatoria,
            'convocatoria.id_estadoConvocatoria' => $this->id_estadoConvocatoria,
            'convocatoria.fecha_inicio' => $this->fecha_inicio,
            'convocatoria.fecha_termino' => $this->fecha_termino,
            'convocatoria.observacion'=>$this->observacion,
        ]);

        $query->andFilterWhere(['like', 'nombreConvocatoria', $this->nombreConvocatoria])->andFilterWhere(['like', 'estadoconvocatoria.nombre_estado', $this->estadoconvocatoria]);

        return $dataProvider;
    }
}
