<?php

namespace patrimonio\parametros;
use Yii;

/**
 * This is the model class for table "patrimonio.rubro".
 *
 * @property int $id
 * @property string $codigo_presupuestario Codigo del rubro al que pertenece el bien de uso
 * @property string $sub_division Datos de auditoria
 * @property string $denominacion Denominacion del rubro al que pertenece el bien de uso
 * @property int $nro_anos_vida_util
 * @property int $porc_amortizacion_anual
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_baja Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_modificacion Datos de auditoria
 * @property int $nivel Nivel al que pertenece el rubro del bien solicitado
 * @property int $id_rubro_padre Identificador del rubro padre al que pertenece el rubro del bien 
 */
class PatrimonioRubro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.rubro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'codigo_presupuestario','sub_division','nro_anos_vida_util'], 'required'],
            [[ 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion'  ], 'default', 'value' => null],
            [['id', 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion','nro_anos_vida_util','porc_amortizacion_anual'], 'integer'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
            [['codigo_presupuestario', 'denominacion'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_presupuestario' => 'Codigorubro',
            'denominacion' => 'Denominacion',
            'fecha_baja' => 'Fechabaja',
            'fecha_carga' => 'Fechacarga',
            'fecha_modificacion' => 'Fechamodificacion',
            'id_usuario_baja' => 'Idusuariobaja',
            'id_usuario_carga' => 'Idusuariocarga',
            'id_usuario_modificacion' => 'Idusuariomodificacion',
            'nro_anos_vida_util'=>'Vida Util',
            'porc_amortizacion_anual' => ' Porcentaje de amortización anual'
        ];
    }
    public function getStrRubro(){
        return $this->codigo_presupuestario.'.'.$this->sub_division.' - '.$this->denominacion;
    
}

public function getVidaUtil(){
    return $this->nro_anos_vida_util;

}
}
