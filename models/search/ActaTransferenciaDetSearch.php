<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\ActaTransferenciaDet;

/**
 * ActaTransferenciaDetSearch represents the model behind the search form of `app\models\ActaTransferenciaDet`.
 */
class ActaTransferenciaDetSearch extends ActaTransferenciaDet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','id_cab', 'id_bien_uso', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_condicion', 'id_agente_tecnico', 'id_agente_patrimonio'], 'integer'],
            [['observaciones', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['necesidad_aprobacion', 'aprobacion_tecnico'], 'boolean'],
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
        $query = ActaTransferenciaDet::find();

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
            'id_cab'=>$this->id_cab,
            'id_bien_uso' => $this->id_bien_uso,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_condicion' => $this->id_condicion,
            'necesidad_aprobacion' => $this->necesidad_aprobacion,
            'id_agente_tecnico' => $this->id_agente_tecnico,
            'id_agente_patrimonio' => $this->id_agente_patrimonio,
            'aprobacion_tecnico' => $this->aprobacion_tecnico,
            
        ]);

        $query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
