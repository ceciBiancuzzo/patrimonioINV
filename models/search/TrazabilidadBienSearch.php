<?php

namespace patrimonio\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use patrimonio\models\TrazabilidadBien;
use gestion_personal\models\PersonalOrganigrama;
use patrimonio\models\BienUso;

/**
 * TrazabilidadBienSearch represents the model behind the search form of `app\models\TrazabilidadBien`.
 */
class TrazabilidadBienSearch extends TrazabilidadBien
{
    /**
     * {@inheritdoc}
     */
    public $rangoFecha;
    public $strSeccion;
    public $strBien;
    public function rules()
    {
        return [
            [[ 'id','id_estado', 'id_condicion', 'id_bien_uso', 'id_usuario_actual','id_area_actual','strBien', 'id_transferencia', 'id_recepcion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'integer'],
            [['id_bien_uso','fecha_alta', 'comentario', 'fecha_baja', 'fecha_modificacion', 'fecha_carga','rangoFecha','tipo_movimiento','strSeccion','id_usuario_actual'], 'safe'],
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
<<<<<<< HEAD
        $query = TrazabilidadBien::find()->orderBy('id DESC');

=======
        $query = TrazabilidadBien::find()->orderBy('fecha_carga ASC');
        
>>>>>>> aprobacion_bodega-gerFinal
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->rangoFecha = $this->getAttribute('rangoFecha');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // $strSeccion = null;
        // if($this->getAttribute('id_area_actual'!= null)){
        //     $this->getAttribute('id_area_actual',strtoupper($this->getAttribute('id_area_actual')));
        //     $str = Patrimonio::find()->where(['cod_desempenio'=>strtoupper($this->getAttribute('id_area_actual'))])->all();
        //     if($str != null){
        //         $strSeccion = $str[0]->cod_desempenio;

        //     }else{
        //         $strSeccion = "";

        //     }
        // }
        $strBien = null;
        if($this->id_bien_uso != null){
            $this->getAttribute('id_bien_uso',strtoupper($this->getAttribute('id_bien_uso')));
            $str = BienUso::find()->where(['nro_inventario'=>strtoupper($this->getAttribute('id_bien_uso'))])->all();
            \Yii::trace("hola");
            
            if($str != null){
                $strBien = $str[0]->id;
                \Yii::trace($strBien);
            }else{
                $strBien = null;

            }
        }
        \Yii::trace($strBien);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_estado' => $this->id_estado,
            'id_condicion' => $this->id_condicion,
            'id_bien_uso' => $strBien,
            'id_usuario_actual' => $this->id_usuario_actual,
            'id_transferencia' => $this->id_transferencia,
            'fecha_alta' => $this->fecha_alta,
            'id_area_actual' => $this->id_area_actual,
            'id_area_anterior' => $this->id_area_anterior,
            'id_recepcion' => $this->id_recepcion,
            'fecha_baja' => $this->fecha_baja,
            'fecha_modificacion' => $this->fecha_modificacion,
            'fecha_carga' => $this->fecha_carga,
            'id_usuario_carga' => $this->id_usuario_carga,
            'id_usuario_baja' => $this->id_usuario_baja,
            'id_usuario_modificacion' => $this->id_usuario_modificacion,
            'tipo_movimiento' => $this->tipo_movimiento,

        ]);
        if($this->rangoFecha != null){
            $auxRangoFecha = explode(' a ',$this->rangoFecha);
            $query->andWhere(['>=','fecha_carga',AppHelpers::cambiaFechaABd($auxRangoFecha[0])]);
            $query->andWhere(['<=','fecha_carga',AppHelpers::cambiaFechaABd($auxRangoFecha[1]).' 23:59:59']);
        }

        $query->andFilterWhere(['ilike', 'comentario', $this->comentario]);

        return $dataProvider;
    }
}
