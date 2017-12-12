<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Postulacion;

/**
 * PostulacionSearch represents the model behind the search form about `frontend\models\Postulacion`.
 */
class PostulacionSearchNoAdmin extends Postulacion
{
    /**
     * @inheritdoc
     */


    public $concursante;
    public $convocatoria;
    public $estadopostulacion;
    public $rutConcursante;
    public $nombreOrganizacion;
    public $nombreProyecto;
    public $financiamiento_aporte_solicitado;


    public function rules()
    {
        return [

            [['id_postulacion', 'id_convocatoria', 'id_concursante', 'id_estadopostulacion','montoAsignado','financiamiento_aporte_solicitado'], 'integer'],
            [['fecha_postulacion'], 'safe'],
            [['concursante','convocatoria','estadopostulacion', 'rutConcursante', 'nombreOrganizacion', 'nombreProyecto'], 'safe'],
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
        $query->joinWith(['convocatoria','concursante','estadopostulacion','formulario']);


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

           $dataProvider->sort->attributes['rutConcursante'] = [
          'asc' => ['concursante.rut' => SORT_ASC],
        'desc' => ['concursante.rut' => SORT_DESC],
    ];    

           $dataProvider->sort->attributes['nombreOrganizacion'] = [
          'asc' => ['formulario.nombre_organizacion' => SORT_ASC],
        'desc' => ['formulario.nombre_organizacion' => SORT_DESC],
    ];  

           $dataProvider->sort->attributes['nombreProyecto'] = [
          'asc' => ['formulario.nombre_proyecto' => SORT_ASC],
        'desc' => ['formulario.nombre_proyecto' => SORT_DESC],
    ];      

          $dataProvider->sort->attributes['financiamiento_aporte_solicitado'] = [
          'asc' => ['formulario.financiamiento_aporte_solicitado' => SORT_ASC],
        'desc' => ['formulario.financiamiento_aporte_solicitado' => SORT_DESC],
    ];    

           $dataProvider->sort->attributes['estadopostulacion'] = [
          'asc' => ['estadopostulacion.nombre_estadopostulacion' => SORT_ASC],
        'desc' => ['estadopostulacion.nombre_estadopostulacion' => SORT_DESC],
    ];

           $dataProvider->sort->attributes['montoAsignado'] = [
          'asc' => ['postulacion.montoAsignado' => SORT_ASC],
        'desc' => ['postulacion.montoAsignado' => SORT_DESC],
    ];    
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       
       
 
        // grid filtering conditions
        $query->andFilterWhere([
            'postulacion.id_postulacion' => $this->id_postulacion,
            'postulacion.id_convocatoria' => $this->id_convocatoria,
            'postulacion.id_concursante' => $this->id_concursante,
               // 'nombreConcursante' => $this->nombreConcursante,
            'postulacion.id_estadopostulacion' => $this->id_estadopostulacion,
            //'postulacion.fecha_postulacion'=>$this->fecha_postulacion,
            
        ])->andFilterWhere(['like', 'convocatoria.nombreConvocatoria', $this->convocatoria])->andFilterWhere(['>','postulacion.id_estadopostulacion', 1])->andFilterWhere(['like', 'concursante.nombreConcursante', $this->concursante])->andFilterWhere(['like', 'concursante.rut', $this->rutConcursante])->andFilterWhere(['like', 'formulario.nombre_organizacion', $this->nombreOrganizacion])->andFilterWhere(['like', 'formulario.nombre_proyecto', $this->nombreProyecto])->andFilterWhere(['like', 'estadopostulacion.nombre_estadopostulacion', $this->estadopostulacion])
        ->andFilterWhere(['like', 'postulacion.montoAsignado', $this->montoAsignado])
        ->andFilterWhere(['like', 'formulario.financiamiento_aporte_solicitado', $this->montoAsignado])
        ->andFilterWhere(['or',['like', 'postulacion.fecha_postulacion', $this->fecha_postulacion],
                                ['like','DATE_FORMAT(postulacion.fecha_postulacion, "%d-%m-%Y")', $this->fecha_postulacion],
            ]);

        return $dataProvider;
    }
}