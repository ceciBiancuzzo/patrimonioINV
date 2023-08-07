<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\parametros\Proveedor;

/**
 * ProveedorSearch represents the model behind the search form of `patrimonio\models\Proveedor`.
 */
class ProveedorSearch extends Proveedor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario_modificacion', 'id_usuario_carga', 'id_usuario_baja', 'id_provincia', 'id_localidad', 'id_departamento', 'id'], 'integer'],
            [['fecha_modificacion', 'fecha_carga', 'fecha_baja', 'fax', 'email', 'domicilio', 'denominacion', 'cuit', 'condicioniva', 'telefono'], 'safe'],
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
        $query = Proveedor::find()->where(['fecha_baja' => null]);

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
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_provincia' => $this->id_provincia,
            'id_localidad' => $this->id_localidad,
            'id_departamento' => $this->id_departamento,
            'id' => $this->id,
            'fecha_modificacion' => $this->fecha_modificacion,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
        ]);

        $query->andFilterWhere(['ilike', 'fax', $this->fax])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'domicilio', $this->domicilio])
            ->andFilterWhere(['ilike', 'denominacion', $this->denominacion])
            ->andFilterWhere(['ilike', 'cuit', $this->cuit])
            ->andFilterWhere(['ilike', 'condicioniva', $this->condicioniva])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
