<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\SolicitudDet;

/**
 * SolicitudDetSearch represents the model behind the search form of `app\models\SolicitudDet`.
 */
class SolicitudDetSearch extends SolicitudDet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cantidad_solicitada', 'cantidad_autorizada', 'saldo_entrega', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja', 'id_solicitud_cab'], 'integer'],
            [['descripcion', 'cantidad', 'observaciones', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
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
        $query = SolicitudDet::find();

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
            'cantidad_solicitada' => $this->cantidad_solicitada,
            'cantidad_autorizada' => $this->cantidad_autorizada,
            'saldo_entrega' => $this->saldo_entrega,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_solicitud_cab' => $this->id_solicitud_cab,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'cantidad', $this->cantidad])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
