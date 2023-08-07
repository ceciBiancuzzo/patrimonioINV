<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\parametros\PatrimonioDependencia;


/**
 * ActaRecepcionCabeceraSearch represents the model behind the search form of `app\models\ActaRecepcionCabecera`.
 */
class ActaRecepcionCabeceraSearch extends ActaRecepcionCabecera
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion','id_forma_adquisicion'], 'integer'],
            [['nro_acta', 'orden_compra', 'fecha_acta', 'fecha_carga', 'fecha_baja', 'fecha_modificacion', 'nro_expediente'], 'safe'],
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
    public function search($params,$mostrar,$areaTransfiere)
    {   
        if($mostrar==false){
        $query = ActaRecepcionCabecera::find()->where(['fecha_baja' => null])->orderBy('id DESC')
        ->select('a.id,a.id_dependencia,a.orden_compra,a.fecha_acta,a.nro_acta,a.id_estado')
        ->from('patrimonio.acta_recepcion_cab a')
        ->leftJoin('patrimonio.acta_recepcion_det b', 'b.id_cab = a.id')
        ->where(['fecha_baja'=> null]);
        }else{
        $query = ActaRecepcionCabecera::find()
        ->where(['fecha_baja' => null]);
        }
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
        if($mostrar == false){
            $areas = [];
            foreach($areaTransfiere as $area){
                array_push($areas,$area->id);
                //$areas = $area->id . ',' . $areas;
            }
            $query->where(['IN','b.id_area_tecnica', $areas]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
           
            'fecha_acta' => $this->fecha_acta,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
        ]);

        $query->andFilterWhere(['ilike', 'nro_acta', $this->nro_acta])
            ->andFilterWhere(['ilike', 'orden_compra', $this->orden_compra])
            ->andFilterWhere(['ilike', 'nro_expediente', $this->nro_expediente])
            ->andFilterWhere(['ilike', 'id_forma_adquisicion', $this->id_forma_adquisicion]);
         

        return $dataProvider;
    }
}
