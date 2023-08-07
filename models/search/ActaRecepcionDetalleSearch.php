<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\ActaRecepcionDetalle;

/**
 * ActaRecepcionDetalleSearch represents the model behind the search form of `patrimonio\models\ActaRecepcionDetalle`.
 */
class ActaRecepcionDetalleSearch extends ActaRecepcionDetalle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cantidad', 'id_proveedor', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_bien_uso', 'id_agente_tecnico', 'id_agente_tecnico1', 'id_agente_patrimonio', 'id_cab', 'id_condicion'], 'integer'],
            [['informe_tecnico', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['necesidad_aprobacion', 'aprobacion_tecnico', 'aprobacion_tecnico1'], 'boolean'],
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
        $query = ActaRecepcionDetalle::find()
        ->where(['fecha_baja'=> null]);

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
            'cantidad' => $this->cantidad,
            'id_proveedor' => $this->id_proveedor,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_bien_uso' => $this->id_bien_uso,
            'id_agente_tecnico' => $this->id_agente_tecnico,
            'id_agente_tecnico1' => $this->id_agente_tecnico1,
            'id_agente_patrimonio' => $this->id_agente_patrimonio,
            'necesidad_aprobacion' => $this->necesidad_aprobacion,
            'aprobacion_tecnico' => $this->aprobacion_tecnico,
            'aprobacion_tecnico1' => $this->aprobacion_tecnico1,
            'id_cab' => $this->id_cab,
            'id_condicion' => $this->id_condicion,
        ]);

        $query->andFilterWhere(['ilike', 'informe_tecnico', $this->informe_tecnico]);

        return $dataProvider;
    }
}
