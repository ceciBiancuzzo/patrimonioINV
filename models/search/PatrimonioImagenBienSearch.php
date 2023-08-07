<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\PatrimonioImagenBien;

/**
 * PatrimonioImagenBienSearch represents the model behind the search form of `patrimonio\models\PatrimonioImagenBien`.
 */
class PatrimonioImagenBienSearch extends PatrimonioImagenBien
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_bien_uso'], 'integer'],
            [['ruta_archivo', 'observaciones','imagen_bien'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = PatrimonioImagenBien::find();

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
            'id' => $this->id,
            'id_bien_uso' => $this->id_bien_uso,
        ]);

        $query->andFilterWhere(['ilike', 'ruta_archivo', $this->ruta_archivo])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones])
            ->andFilterWhere(['ilike', 'imagen_bien', $this->imagen_bien]);
        return $dataProvider;
    }
}
