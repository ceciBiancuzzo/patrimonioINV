<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\parametros\PatrimonioMarca;

/**
 * PatrimonioMarcaSearch represents the model behind the search form of `patrimonio\parametros\PatrimonioMarca`.
 */
class PatrimonioMarcaSearch extends PatrimonioMarca
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion'], 'integer'],
            [['denominacion', 'fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
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
        $query = PatrimonioMarca::find()->where(['fecha_baja' => null]);

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
            'fecha_baja' => $this->fecha_baja,
            'fecha_carga' => $this->fecha_carga,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
        ]);

        $query->andFilterWhere(['ilike', 'denominacion', $this->denominacion]);

        return $dataProvider;
    }
}
