<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\ActaTransferenciaCab;
use gestion_personal\models\PersonalOrganigrama;
use patrimonio\parametros\PatrimonioDependencia;
/**
 * ActaTransferenciaCabSearch represents the model behind the search form of `app\models\ActaTransferenciaCab`.
 */
class ActaTransferenciaCabSearch extends ActaTransferenciaCab
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'nro_acta_transferencia','id_estado_formulario','tipo_solicitud','id_dependencia2','id_dependencia'], 'integer'],
            [['fecha_recepcion', 'fecha_transferencia', 'observaciones', 'fecha_carga', 'fecha_baja', 'fecha_modificacion','fecha_aprobacion'], 'safe'],
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
    public function search($params,$areaTransfiere,$mostrar,$area2)
    {   
        //print_r($params);die();
        $areas = [];
        foreach($areaTransfiere as $area){
            array_push($areas,$area->id);
            //$areas = $area->id . ',' . $areas;
        }
        if($mostrar == true){
        $query = ActaTransferenciaCab::find()
        ->where(['fecha_baja' => null])->orderBy('id DESC');
        
        }else{
            $query = ActaTransferenciaCab::find()
            ->where(['fecha_baja' => null])->orderBy('id DESC')
            ->andWhere(
                    ['OR',
                        ['IN','id_dependencia',$areas],
                        ['IN','id_dependencia2',$areas]
                    ]);
        }
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
        // die();
     
        // ->andWhere(
        //     ['OR',
        //         ['id_seccion'=>$area],
        //         ['id_seccion2'=>$area]
        //     ]);
        // // add conditions that should always apply here

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
       
        if($mostrar == true){
        $query->andFilterWhere([
            'id' => $this->id,   
            'fecha_recepcion' => $this->fecha_recepcion,
            'fecha_transferencia' => $this->fecha_transferencia,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'nro_acta_transferencia' => $this->nro_acta_transferencia,
            'id_estado_formulario'=>$this->id_estado_formulario,
            'tipo_solicitud'=>$this->tipo_solicitud,

        ]);
    }else{
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_recepcion' => $this->fecha_recepcion,
            'fecha_transferencia' => $this->fecha_transferencia,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'nro_acta_transferencia' => $this->nro_acta_transferencia,
            'id_estado_formulario'=>$this->id_estado_formulario,
            'tipo_solicitud'=>$this->tipo_solicitud,

        ]);

    }
        $query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);
        $query->andFilterWhere(['OR',  
                    ['id_dependencia' => $this->id_dependencia],
                    ['id_dependencia2' => $this->id_dependencia2]
                ]);

        //print_r($query);die();
        return $dataProvider;
    }
}
