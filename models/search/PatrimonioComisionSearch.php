<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\PatrimonioComision;

/**
 * PatrimonioComisionSearch represents the model behind the search form of `patrimonio\models\PatrimonioComision`.
 */
class PatrimonioComisionSearch extends PatrimonioComision
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'anio', 'persona1', 'persona2', 'persona3', 'persona4', 'persona5', 'persona6', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['denominacion', 'fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
            [['activa'], 'boolean'],
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
        $query = PatrimonioComision::find()->where(['fecha_baja' => null]);

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
            'anio' => $this->anio,
            'persona1' => $this->persona1,
            'persona2' => $this->persona2,
            'persona3' => $this->persona3,
            'persona4' => $this->persona4,
            'persona5' => $this->persona5,
            'persona6' => $this->persona6,
            'activa' => $this->activa,
            'fecha_carga' => $this->fecha_carga,
            'fecha_modificacion' => $this->fecha_modificacion,
            'fecha_baja' => $this->fecha_baja,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
        ]);

        $query->andFilterWhere(['ilike', 'denominacion', $this->denominacion]);

        return $dataProvider;
    }
}
