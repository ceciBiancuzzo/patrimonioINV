<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\AsignacionDeBienes;
use patrimonio\models\BienUso;
/**
 * AsignacionDeBienesSearch represents the model behind the search form of `patrimonio\models\AsignacionDeBienes`.
 */
class AsignacionDeBienesSearch extends AsignacionDeBienes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
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
        $query = BienUso::find()->where(['fecha_baja' => null])->orderBy('id DESC');

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
            'id_usuario' => $this->id_usuario,
            'fecha_carga' => $this->fecha_carga,
            'fecha_modificacion' => $this->fecha_modificacion,
            'fecha_baja' => $this->fecha_baja,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
        ]);

        return $dataProvider;
    }
    public function searchBienAmortizado($areaTransfiere,$mostrar)
    {
         //print_r($areaTransfiere);die();
        // foreach($areaTransfiere as $area){
            
        //     $query = BienUso::find()
        //     ->where(['id_dependencia' => $area->id]);
        //     // ->where(
        //     //         ['OR',
        //     //             ['id_dependencia'=>$area],
        //     //             //['id_dependencia2'=>$area]
        //     //         ]);
                    
            
        //     }    
        
        $query = BienUso::find();
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /* $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        } */
        //print_r($areaTransfiere);die();
        $query->where(['IN', 'id_estado_interno', [2,3,4]]);
        $areas = [];
        foreach($areaTransfiere as $area){
            array_push($areas,$area->id);
            //$areas = $area->id . ',' . $areas;
        }
        //$areaFinal = '['. substr($areas,0, -1) . ']';
        //print_r($areas);die();
        if($mostrar == false){
            $query->where(['IN','id_dependencia', $areas]);
        
        }
        //$query->andWhere(['=', 'r.codigo_presupuestario',$nro_rubro]);
        //$query->andFilterWhere(['id_seccion_bien' => $params,]);
        //print_r($query);die();

        return $dataProvider;
    }
}
