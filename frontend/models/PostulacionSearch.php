<?php

namespace frontend\models;

use backend\models\Fondo;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Postulacion;

/**
 * PostulacionSearch represents the model behind the search form about `frontend\models\Postulacion`.
 */
class PostulacionSearch extends Postulacion
{
    /**
     * @inheritdoc
     */


    public $concursante;
    public $convocatoria;
    public $estadopostulacion;

    public function rules()
    {
        return [

            [['id_postulacion', 'id_convocatoria', 'id_concursante', 'id_estadopostulacion'], 'integer'],
            [['fecha_postulacion'], 'safe'],
            [['concursante','convocatoria','estadopostulacion'], 'safe'],
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

        $query = Postulacion::find();
        $query->joinWith(['convocatoria','concursante','estadopostulacion']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



         $dataProvider->sort->attributes['convocatoria'] = [
          'asc' => ['convocatoria.nombreConvocatoria' => SORT_ASC],
        'desc' => ['convocatoria.nombreConvocatoria' => SORT_DESC],
    ];

           $dataProvider->sort->attributes['concursante'] = [
          'asc' => ['concursante.nombreConcursante' => SORT_ASC],
        'desc' => ['concursante.nombreConcursante' => SORT_DESC],
    ];


           $dataProvider->sort->attributes['estadopostulacion'] = [
          'asc' => ['estadopostulacion.nombre_estadopostulacion' => SORT_ASC],
        'desc' => ['estadopostulacion.nombre_estadopostulacion' => SORT_DESC],
    ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_postulacion' => $this->id_postulacion,
            'id_convocatoria' => $this->id_convocatoria,
            'id_concursante' => $this->id_concursante,
               // 'nombreConcursante' => $this->nombreConcursante,
            'id_estadopostulacion' => $this->id_estadopostulacion,
            'fecha_postulacion' => $this->fecha_postulacion,
        ])->andFilterWhere(['like', 'convocatoria.nombreConvocatoria', $this->convocatoria])->andFilterWhere(['like', 'concursante.nombreConcursante', $this->concursante])->andFilterWhere(['like', 'estadopostulacion.nombre_estadopostulacion', $this->estadopostulacion]);

        return $dataProvider;
    }
}
