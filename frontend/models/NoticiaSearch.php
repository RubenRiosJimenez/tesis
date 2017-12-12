<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Noticia;

/**
 * NoticiaSearch represents the model behind the search form about `frontend\models\Noticia`.
 */
class NoticiaSearch extends Noticia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_noticia', 'id'], 'integer'],
            [['noticia_principal', 'noticia_secundaria', 'noticia_terciaria'], 'safe'],
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
        $query = Noticia::find();

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
            'id_noticia' => $this->id_noticia,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'noticia_principal', $this->noticia_principal])
            ->andFilterWhere(['like', 'noticia_secundaria', $this->noticia_secundaria])
            ->andFilterWhere(['like', 'noticia_terciaria', $this->noticia_terciaria]);

        return $dataProvider;
    }
}
