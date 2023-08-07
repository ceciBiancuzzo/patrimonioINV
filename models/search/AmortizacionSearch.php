<?php

namespace patrimonio\models\search;
use Yii;
use yii\data\ArrayDataProvider;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\Amortizacion;
use patrimonio\models\BienUso;

/**
 * AmortizacionSearch represents the model behind the search form of `patrimonio\models\Amortizacion`.
 */
class AmortizacionSearch extends Amortizacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'amortizacion_anual', 'amortizacion_anual_acumulada', 'valor_residual', 'anio', 'r_431', 'r_432', 'r_433', 'r_434', 'r_435', 'r_436', 'r_437', 'r_438', 'r_439', 'r_481','r_411','r_412','id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
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
        $query = Amortizacion::find()
        ->where(['fecha_baja' => null])->orderBy('id DESC');
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
            'amortizacion_anual' => $this->amortizacion_anual,
            'amortizacion_anual_acumulada' => $this->amortizacion_anual_acumulada,
            'valor_residual' => $this->valor_residual,
            'anio' => $this->anio,
          
            'r_431' => $this->r_431,
            'r_432' => $this->r_432,
            'r_433' => $this->r_433,
            'r_434' => $this->r_434,
            'r_435' => $this->r_435,
            'r_436' => $this->r_436,
            'r_437' => $this->r_437,
            'r_438' => $this->r_438,
            'r_439' => $this->r_439,
            'r_481' => $this->r_481,
            'r_411' => $this->r_411,
            'r_412' => $this->r_412,
            'fecha_carga' => $this->fecha_carga,
            'fecha_modificacion' => $this->fecha_modificacion,
            'fecha_baja' => $this->fecha_baja,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'id_usuario_baja' => $this->id_usuario_baja,
        ]);

        return $dataProvider;
    }


    public function searchBienAmortizado($params, $nro_rubro)
    {
    
        $query = BienUso::find()
         ->select('b.id, b.nro_inventario, b.id_rubro, b.tipo_bien, b.precio_origen,b.amortizable,
         b.valor_rezago,b.vida_util,b.vida_util_transcurrida,b.valor_residual,b.anio_alta,b.amortizacion_anual,b.amortizacion_anual_acumulada' )
        ->from('patrimonio.bien_uso b')
        ->leftJoin('patrimonio.amortizacion a', 'a.id_bien_uso = b.id')
        ->leftJoin('patrimonio.rubro r','r.id=b.id_rubro')
        ->where('b.precio_origen is not null')
        ->andwhere(['!=', 'b.vida_util', 0])
        ->andwhere(['=','b.amortizable',true]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>false
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andWhere(['IN', 'id_estado_interno', [2,3,4]]);
        $query->andWhere(['=', 'r.codigo_presupuestario',$nro_rubro]);
        $query->andFilterWhere(['id_seccion_bien' => $params,]);

        return $dataProvider;
    }
    public function searchExcel431($params)
    {
        set_time_limit(0);

        $this->load($params);
   
    
        $sql = "
        select b.id, b.nro_inventario, r.codigo_presupuestario, b.descripcion_bien, b.precio_origen,b.amortizable,
        b.valor_rezago,b.vida_util,b.vida_util_transcurrida,b.valor_residual,b.anio_alta,b.amortizacion_anual,b.amortizacion_anual_acumulada
        from patrimonio.bien_uso b
        LEFT JOIN patrimonio.amortizacion a on a.id_bien_uso = b.id
        LEFT JOIN patrimonio.rubro r on r.id=b.id_rubro 
        WHERE b.precio_origen is not null
        and b.vida_util != 0
        and b.amortizable = true
    
        and b.id_estado_interno IN (2,3,4,5)
        order by r.codigo_presupuestario ASC
        ";
        //print_r($sql);die();
        $datos=Yii::$app->db->createCommand($sql)->queryAll();
        return new ArrayDataProvider(['allModels' => $datos,'pagination'=>false]);



        return $dataProvider;
    }
}