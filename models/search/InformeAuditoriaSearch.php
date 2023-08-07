<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\InformeAuditoria;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioDependencia;


/**
 * InformePatrimonialSearch represents the model behind the search form of `patrimonio\models\InformePatrimonial`.
 */
class InformeAuditoriaSearch extends InformeAuditoria
{
    /**
     * {@inheritdoc}
     */
    public $strSeccion;
    public function rules()
    {
        return [
            [['id', 'id_usuario_aprobacion', 'id_bien_uso','strSeccion'], 'integer'],
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
    public function search($params)
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
        
        if($this->id != null){
            \Yii::trace("hola");
<<<<<<< HEAD
            \Yii::trace($areaTransfiere);
=======
>>>>>>> aprobacion_bodega-gerFinal
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
        
        $query->andFilterWhere([
            'id' => $this->id,
           // 'id_area'=>$areaTransfiere,
            'id_usuario_aprobacion' => $this->id_usuario_aprobacion,
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fecha_presentacion' => $this->fecha_presentacion,
            'fecha_carga' => $this->fecha_carga,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'id_bien_uso' => $this->id_bien_uso,
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
}
