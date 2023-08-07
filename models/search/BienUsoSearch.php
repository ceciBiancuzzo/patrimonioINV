<?php

namespace patrimonio\models\search;
use Yii;
use yii\data\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\BienUso;
use common\models\helpers\AppHelpers as HelpersAppHelpers;
use common\models\helpers\AppHelpers;

/**
 * BienUsoSearch represents the model behind the search form of `app\models\BienUso`.
 */
class BienUsoSearch extends BienUso
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_acta_recepcion_definitiva','id_usuario_bien', 'id', 'id_acta_transferencia', 'id_marca', 'id_rubro', 'id_usuario_carga', 'id_usuario_modificacion', 'id_condicion','id_dependencia', 'id_estado_interno', 'id_usuario_baja', 'nro_inventario','anio_alta'], 'integer'],
            [['descripcion_bien','tipo_bien', 'fecha_baja', 'fecha_carga', 'fecha_modificacion', 'modelo', 'donacion', 'codigo_item_catalogo', 'observaciones', 'tipo_identificacion', 'nro_serie','rangoFecha','usuario_externo'], 'safe'],
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
        set_time_limit(0);

        $this->load($params);
        
        $es ="  ";
        if($this->id_estado_interno > 0 ){
            $es = " and b.id_estado_interno = ".$this->id_estado_interno."   ";
            if($this->id_estado_interno == 1){
                $es = " and b.id_estado_interno = ".$this->id_estado_interno." and b.nro_inventario is null  ";
            }
        }

        $nro_in ="  ";
        if($this->nro_inventario>0 ){
            $nro_in = " and b.nro_inventario =".$this->nro_inventario ."   ";
        } 
        $ru ="  ";

        //print_r($this->id_rubro);die();
        if($this->id_rubro>0){
            if($this->id_rubro == 1){
                $ru = " and b.id_rubro in(1,2,3,4,5)";
            } 
            if($this->id_rubro == 7 ){
                $ru = " and b.id_rubro in(7,8,9,10,11,12,13,14)";
            } 
            if($this->id_rubro == 15 ){
                $ru = " and b.id_rubro in(15,16,17,18,19)";
            } 
            if($this->id_rubro == 20 ){
                $ru = " and b.id_rubro in(20,21,22,23,24,25,26,27,28,29,30,31)";
            } 
            if($this->id_rubro == 32){
                $ru = " and b.id_rubro in(33,34,35,36,37)";
            } 
            if($this->id_rubro == 38 ){
                $ru = " and b.id_rubro in(38,39,40,41,42,43,44,45)";
            } 
            if($this->id_rubro == 46 ){
            // $ru="*******************************";
                $ru = " and b.id_rubro in(46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61)";
            } 
            if($this->id_rubro == 62 ){
                $ru = " and b.id_rubro in(62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81)";
            } 
            if($this->id_rubro == 82 ){
                $ru = " and b.id_rubro in(82,83,84)";
            } 
            if($this->id_rubro == 85 ){
                $ru = " and b.id_rubro in(85,86,87,88,89,90)";
            } 
            if($this->id_rubro == 91 ){
                $ru = " and b.id_rubro in(91,92,93,94,95)";
            } 
            if($this->id_rubro == 96 ){
                $ru = " and b.id_rubro in(96,97,98,99,100,101,102,103,104)";
            } 
            if($this->id_rubro == 105 ){
                $ru = " and b.id_rubro in(105,106,107)";
            } 
            if($this->id_rubro != 1 && $this->id_rubro != 7 && $this->id_rubro != 15  && $this->id_rubro != 20 && $this->id_rubro != 32 
            && $this->id_rubro != 38 && $this->id_rubro != 46 && $this->id_rubro != 62 && $this->id_rubro != 82 && $this->id_rubro != 85
            && $this->id_rubro != 91 && $this->id_rubro != 96 && $this->id_rubro != 105) {
                $ru = " and b.id_rubro =".$this->id_rubro ."   ";
            } 
        }
        
        $tb ="  ";
        if($this->id>0 ){
            $tb = " and b.id =".$this->id ."   ";
        } 
        $ns ="  ";
        if($this->nro_serie != '' ){
            $ns = " and b.nro_serie ='".$this->nro_serie ."'   ";
        } 
        $de ="  ";
        if($this->id_dependencia>0){
            $de = " and b.id_dependencia ='".$this->id_dependencia ."'   ";
        }
        $aa="  ";
        if($this->anio_alta>0){
            $aa = " and b.anio_alta ='".$this->anio_alta ."'   ";
            //print_r($aa);die();

        }
        $ti = "  ";
        if($this->tipo_bien != '' ){
            $ti = " and b.tipo_bien LIKE TRIM(upper('%".$this->tipo_bien."%'))   ";

        }
        $desc = "  ";
        if($this->descripcion_bien != '' ){

            $desc = " and b.descripcion_bien LIKE TRIM(upper('%".$this->descripcion_bien."%'))  ";

        }
        $ma="  ";
        if($this->id_marca>0){
            $ma = " and b.id_marca ='".$this->id_marca ."'   ";
            //print_r($aa);die();

        }
        $sql = "
        select b.id,b.nro_inventario,b.id_rubro,b.id_condicion,b.tipo_bien,b.id_marca,b.modelo,b.nro_serie,
        b.id_dependencia,b.id_estado_interno,b.fecha_carga
        from patrimonio.bien_uso b
        where b.fecha_baja is null
       
        ".$es."  ".$nro_in."  ".$ru."  ".$tb."  ".$ns."  ".$de."  ".$aa." ".$ma."  ".$desc."  ".$ti."
        order by b.id DESC  ";
        //print_r($sql);die();
        $datos=Yii::$app->db->createCommand($sql)->queryAll();

        $array_data = [];
        foreach($datos as $dato){
            $customBienUso= new BienUso();
            $customBienUso->id = $dato['id'];
            $customBienUso->nro_inventario = $dato['nro_inventario'];
            $customBienUso->id_rubro = $dato['id_rubro'];
            $customBienUso->id_condicion = $dato['id_condicion'];
            $customBienUso->tipo_bien = $dato['tipo_bien'];
            $customBienUso->id_marca = $dato['id_marca'];
            $customBienUso->modelo = $dato['modelo'];
            $customBienUso->fecha_carga = $dato['fecha_carga'];
            $customBienUso->nro_serie = $dato['nro_serie'];
            $customBienUso->id_dependencia = $dato['id_dependencia'];
            $customBienUso->id_estado_interno = $dato['id_estado_interno'];
            

           array_push($array_data,$customBienUso);
        }
        // $query = BienUso::find();
        // ->innerJoin([
        //     'bienUsoContables',
        //     'marcas'
        // ]);

        // add conditions that should always apply here

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

       ///$this->load($params);
       $dataProvider = new ArrayDataProvider([
        'allModels' => $array_data,

            'pagination' => [
                'pageSize' =>100,
                ]
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
           //  $query->where('0=1');
           return new \yii\data\ArrayDataProvider([
                    'allModels'=>[],
                ]);
        }

        // // grid filtering conditions
        // $query->andFilterWhere([
        //     'id_acta_recepcion_definitiva' => $this->id_acta_recepcion_definitiva,
        //     'fecha_baja' => $this->fecha_baja,
        //     'fecha_carga' => $this->fecha_carga,
        //     'fecha_modificacion' => $this->fecha_modificacion,
        //     'id' => $this->id,
        //     'id_acta_transferencia' => $this->id_acta_transferencia,
        //     'id_marca' => $this->id_marca,
        //     'id_rubro' => $this->id_rubro,
        //     'id_usuario_carga' => $this->id_usuario_carga,
        //     'id_usuario_modificacion' => $this->id_usuario_modificacion,
        //     'nro_serie' => $this->nro_serie,
        //     'id_condicion' => $this->id_condicion,
        //     'id_trazabilidad_del_bien' => $this->id_trazabilidad_del_bien,
        //     'id_estado_interno' => $this->id_estado_interno,
        //     'id_usuario_baja' => $this->id_usuario_baja,
        //     'nro_inventario' => $this->nro_inventario,
        //     'id_dependencia' => $this->id_dependencia,
        // ]);

        // $query->andFilterWhere(['ilike', 'descripcion_bien', $this->descripcion_bien])
        //     ->andFilterWhere(['ilike', 'modelo', $this->modelo])
        //     ->andFilterWhere(['ilike', 'donacion', $this->donacion])
        //     ->andFilterWhere(['ilike', 'codigo_item_catalogo', $this->codigo_item_catalogo])
        //     ->andFilterWhere(['ilike', 'observaciones', $this->observaciones])
        //     ->andFilterWhere(['ilike', 'tipo_identificacion', $this->tipo_identificacion]);


        return $dataProvider;
    }
    public function searchBienAmortizado($areaTransfiere,$mostrar,$params)
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
        
        $query = BienUso::find()->where(['fecha_baja'=>null]);
       
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
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($mostrar == false){
            $query->where(['IN','id_dependencia', $areas]);
        
        }
 
        if(true){
            $query->andFilterWhere([
                'id' => $this->id,
                'id_usuario_bien' => $this->id_usuario_bien,
                'id_estado_interno' => $this->id_estado_interno,
                'id_rubro' => $this->id_rubro,
                'nro_inventario' => $this->nro_inventario,
                'id_dependencia' => $this->id_dependencia,
                'nro_serie' => $this->nro_serie,
                'anio_alta' => $this->anio_alta,
    
            ]);


        }
        $query->andFilterWhere(['ilike', 'usuario_externo', $this->usuario_externo]);

        return $dataProvider;
    }
    public function searchExcel($params)
    {
        set_time_limit(0);

        $this->load($params);
        
    
        $sql = "
        select b.nro_inventario,r.codigo_presupuestario,b.descripcion_bien,b.precio_origen,b.vida_util,
        b.amortizacion_anual,b.vida_util_transcurrida,b.amortizacion_anual_acumulada,
        b.valor_residual,b.valor_rezago,b.anio_alta,b.amortizacion_anual_acumulada_anterior,
        b.amortizacion_anual_anterior,b.acto_admin,b.fecha_baja_definitiva,b.observaciones from patrimonio.bien_uso b 
        INNER JOIN patrimonio.rubro r on r.id = b.id_rubro where b.nro_inventario is not null
        and b.fecha_baja is null
        order by b.nro_inventario ASC
        ";
        //print_r($sql);die();
        $datos=Yii::$app->db->createCommand($sql)->queryAll();
        return new ArrayDataProvider(['allModels' => $datos,'pagination'=>false]);
    //     $array_data = [];
    //     foreach($datos as $dato){
    //         $customBienUso= new BienUso();
    //         $customBienUso->id = $dato['id'];
    //         $customBienUso->nro_inventario = $dato['nro_inventario'];
    //         $customBienUso->id_rubro = $dato['id_rubro'];
    //         $customBienUso->id_condicion = $dato['id_condicion'];
    //         $customBienUso->tipo_bien = $dato['tipo_bien'];
    //         $customBienUso->id_marca = $dato['id_marca'];
    //         $customBienUso->modelo = $dato['modelo'];
    //         $customBienUso->fecha_carga = $dato['fecha_carga'];
    //         $customBienUso->nro_serie = $dato['nro_serie'];
    //         $customBienUso->id_dependencia = $dato['id_dependencia'];
    //         $customBienUso->id_estado_interno = $dato['id_estado_interno'];
            

    //        array_push($array_data,$customBienUso);
    //     }
    //     // $query = BienUso::find();
    //     // ->innerJoin([
    //     //     'bienUsoContables',
    //     //     'marcas'
    //     // ]);

    //     // add conditions that should always apply here

    //     // $dataProvider = new ActiveDataProvider([
    //     //     'query' => $query,
    //     // ]);

    //    ///$this->load($params);
    //    $dataProvider = new ArrayDataProvider([
    //     'allModels' => $array_data,

    //         'pagination' => [
    //             'pageSize' =>100,
    //             ]
    //     ]);
    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //        //  $query->where('0=1');
    //        return new \yii\data\ArrayDataProvider([
    //                 'allModels'=>[],
    //             ]);
    //     }

        // // grid filtering conditions
        // $query->andFilterWhere([
        //     'id_acta_recepcion_definitiva' => $this->id_acta_recepcion_definitiva,
        //     'fecha_baja' => $this->fecha_baja,
        //     'fecha_carga' => $this->fecha_carga,
        //     'fecha_modificacion' => $this->fecha_modificacion,
        //     'id' => $this->id,
        //     'id_acta_transferencia' => $this->id_acta_transferencia,
        //     'id_marca' => $this->id_marca,
        //     'id_rubro' => $this->id_rubro,
        //     'id_usuario_carga' => $this->id_usuario_carga,
        //     'id_usuario_modificacion' => $this->id_usuario_modificacion,
        //     'nro_serie' => $this->nro_serie,
        //     'id_condicion' => $this->id_condicion,
        //     'id_trazabilidad_del_bien' => $this->id_trazabilidad_del_bien,
        //     'id_estado_interno' => $this->id_estado_interno,
        //     'id_usuario_baja' => $this->id_usuario_baja,
        //     'nro_inventario' => $this->nro_inventario,
        //     'id_dependencia' => $this->id_dependencia,
        // ]);

        // $query->andFilterWhere(['ilike', 'descripcion_bien', $this->descripcion_bien])
        //     ->andFilterWhere(['ilike', 'modelo', $this->modelo])
        //     ->andFilterWhere(['ilike', 'donacion', $this->donacion])
        //     ->andFilterWhere(['ilike', 'codigo_item_catalogo', $this->codigo_item_catalogo])
        //     ->andFilterWhere(['ilike', 'observaciones', $this->observaciones])
        //     ->andFilterWhere(['ilike', 'tipo_identificacion', $this->tipo_identificacion]);


        return $dataProvider;
    }
}