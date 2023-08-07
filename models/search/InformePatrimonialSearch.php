<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\InformePatrimonial;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioDependencia;


/**
 * InformePatrimonialSearch represents the model behind the search form of `patrimonio\models\InformePatrimonial`.
 */
class InformePatrimonialSearch extends InformePatrimonial
{
    /**
     * {@inheritdoc}
     */
    public $strSeccion;
    public function rules()
    {
        return [
            [['id', 'id_usuario_aprobacion', 'id_bien_uso','strSeccion','id_estado_formulario'], 'integer'],
            [['observaciones', 'fecha_aprobacion', 'fecha_presentacion', 'fecha_carga', 'fecha_baja', 'fecha_modificacion','strSeccion','id_area'], 'safe'],
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
    public function search($params,$areaTransfiere,$mostrar)
    {
        //print_r($areaTransfiere);die();
        $query = PatrimonioDependencia::find()->where(['fecha_baja' => null]);
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
        
        if($mostrar == true & $this->id_area != null){
            \Yii::trace("hola");
            \Yii::trace($areaTransfiere);
            $this->getAttribute('id',strtoupper($this->getAttribute('id')));
            $str = PatrimonioDependencia::find()->where(['id'=>strtoupper($this->getAttribute('id'))])->all();
           
            if($str != null){
                $areaTransfiere = $str[0]->id;
            }else{
                $areaTransfiere = '';

            }
        }
        
        // $query->Where(
        //     [
                
        //     'id_area' => $strSeccion,
           
        // ]);

        // grid filtering conditions
        if($mostrar == false){
        $areas = [];
        foreach($areaTransfiere as $area){
            array_push($areas,$area->id);
            //$areas = $area->id . ',' . $areas;
        }
        $query->where(['IN','id', $areas]);
        }
        $query->andFilterWhere([
            'id' => $this->id,
           // 'id_area'=>$areaTransfiere,
            'id_usuario_aprobacion' => $this->id_usuario_aprobacion,
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fecha_presentacion' => $this->fecha_presentacion,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_estado_formulario' => $this->id_estado_formulario,
        ]);
        
        //$query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
    public function searchArea($params)
    {
    
        $query = BienUso::find()
        ->from('patrimonio.bien_uso b')
        ->innerJoin('patrimonio.dependencia i', 'i.id = b.id_dependencia')
        ->where('b.fecha_baja is null')
        ->andWhere('b.nro_inventario is not null');
       // ->where('i.id_area = b.id_area_bien');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' =>100,
                ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
          'id_dependencia' => $params, 
          
          
        ]);

        //$query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
    public function searchSobrantes($params,$area)
    {
        //print_r($areaTransfiere);die();
        $query = PatrimonioDependencia::find()->where(['fecha_baja' => null]);
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
        
        // if($mostrar == true & $this->id_area != null){
        //     \Yii::trace("hola");
        //     \Yii::trace($areaTransfiere);
        //     $this->getAttribute('id',strtoupper($this->getAttribute('id')));
        //     $str = PatrimonioDependencia::find()->where(['id'=>strtoupper($this->getAttribute('id'))])->all();
           
        //     if($str != null){
        //         $areaTransfiere = $str[0]->id;
        //     }else{
        //         $areaTransfiere = '';

        //     }
        // }
        
        // $query->Where(
        //     [
                
        //     'id_area' => $strSeccion,
           
        // ]);

        // // grid filtering conditions
        // if($mostrar == false){
        // $areas = [];
        // foreach($areaTransfiere as $area){
        //     array_push($areas,$area->id);
        //     //$areas = $area->id . ',' . $areas;
        // }
        // $query->where(['IN','id', $areas]);
        // }
        $query->where(['id'=>$area]);
        $query->andFilterWhere([
            'id' => $this->id,
           // 'id_area'=>$areaTransfiere,
            'id_usuario_aprobacion' => $this->id_usuario_aprobacion,
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fecha_presentacion' => $this->fecha_presentacion,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_estado_formulario' => $this->id_estado_formulario,
        ]);
        
        //$query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> aprobacion_bodega-gerFinal
