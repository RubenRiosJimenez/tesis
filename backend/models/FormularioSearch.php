<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Formulario;

/**
 * FormularioSearch represents the model behind the search form about `frontend\models\Formulario`.
 */
class FormularioSearch extends Formulario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_formulario', 'id_postulacion'], 'integer'],
            [['nombre_organizacion', 'rut_organizacion', 'nombre_representanteLegal', 'area_subvencion', 'otra_subvencion', 'telefono_contacto', 'numeroRut_representanteLegal', 'numero_personalidadJuridica', 'fecha_personalidadJuridica', 'organismoQueOtorgo_personalidadJuridica', 'objetivos_generalesOrganizacion', 'financiamiento_organizacion', 'domiciolio_representanteLegal', 'nombre_proyecto', 'numero_unidadVecinal', 'direccion_proyecto', 'objetivos_proyecto', 'descripcion_proyecto', 'numero_beneficiariosDirectos', 'numero_beneficiariosIndirectos', 'descripcion_beneficiariosDirectos', 'financiamiento_aporte_propio', 'financiamiento_aporte_terceros', 'financiamiento_aporte_solicitado', 'financiamiento_aporteTotal_proyecto'], 'safe'],
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
        $query = Formulario::find();

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
            'id_formulario' => $this->id_formulario,
            'id_postulacion' => $this->id_postulacion,
            'fecha_personalidadJuridica' => $this->fecha_personalidadJuridica,
        ]);

        $query->andFilterWhere(['like', 'nombre_organizacion', $this->nombre_organizacion])
            ->andFilterWhere(['like', 'rut_organizacion', $this->rut_organizacion])
            ->andFilterWhere(['like', 'nombre_representanteLegal', $this->nombre_representanteLegal])
            ->andFilterWhere(['like', 'area_subvencion', $this->area_subvencion])
            ->andFilterWhere(['like', 'otra_subvencion', $this->otra_subvencion])
            ->andFilterWhere(['like', 'telefono_contacto', $this->telefono_contacto])
            ->andFilterWhere(['like', 'numeroRut_representanteLegal', $this->numeroRut_representanteLegal])
            ->andFilterWhere(['like', 'numero_personalidadJuridica', $this->numero_personalidadJuridica])
            ->andFilterWhere(['like', 'organismoQueOtorgo_personalidadJuridica', $this->organismoQueOtorgo_personalidadJuridica])
            ->andFilterWhere(['like', 'objetivos_generalesOrganizacion', $this->objetivos_generalesOrganizacion])
            ->andFilterWhere(['like', 'financiamiento_organizacion', $this->financiamiento_organizacion])
            ->andFilterWhere(['like', 'domiciolio_representanteLegal', $this->domiciolio_representanteLegal])
            ->andFilterWhere(['like', 'nombre_proyecto', $this->nombre_proyecto])
            ->andFilterWhere(['like', 'numero_unidadVecinal', $this->numero_unidadVecinal])
            ->andFilterWhere(['like', 'direccion_proyecto', $this->direccion_proyecto])
            ->andFilterWhere(['like', 'objetivos_proyecto', $this->objetivos_proyecto])
            ->andFilterWhere(['like', 'descripcion_proyecto', $this->descripcion_proyecto])
            ->andFilterWhere(['like', 'numero_beneficiariosDirectos', $this->numero_beneficiariosDirectos])
            ->andFilterWhere(['like', 'numero_beneficiariosIndirectos', $this->numero_beneficiariosIndirectos])
            ->andFilterWhere(['like', 'descripcion_beneficiariosDirectos', $this->descripcion_beneficiariosDirectos])
            ->andFilterWhere(['like', 'financiamiento_aporte_propio', $this->financiamiento_aporte_propio])
            ->andFilterWhere(['like', 'financiamiento_aporte_terceros', $this->financiamiento_aporte_terceros])
            ->andFilterWhere(['like', 'financiamiento_aporte_solicitado', $this->financiamiento_aporte_solicitado])
            ->andFilterWhere(['like', 'financiamiento_aporteTotal_proyecto', $this->financiamiento_aporteTotal_proyecto]);

        return $dataProvider;
    }
}
