<?php

namespace patrimonio\models;

use gestion_personal\models\PersonalOrganigrama;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use patrimonio\parametros\PatrimonioDependencia;


use Yii;

/**
 * This is the model class for table "patrimonio.informe_patrimonial".
 *
 * @property int $id
 * @property string $observaciones
 * @property int $id_usuario_aprobacion
 * @property string $fecha_aprobacion
 * @property string $fecha_presentacion
 * @property string $fecha_carga
 * @property string $fecha_baja
 * @property string $fecha_modificacion
 * @property int $id_bien_uso
 */
class InformePatrimonial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.informe_patrimonial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_usuario_aprobacion', 'id_bien_uso'], 'default', 'value' => null],
            [['id', 'id_usuario_aprobacion', 'id_bien_uso'], 'integer'],
            [['observaciones'], 'string'],
            [['fecha_aprobacion', 'fecha_presentacion', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['id'], 'unique'],
         //   [['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'observaciones' => 'Observaciones',
            'id_usuario_aprobacion' => 'Id Usuario Aprobacion',
            'fecha_aprobacion' => 'Fecha Aprobacion',
            'fecha_presentacion' => 'Fecha Presentacion',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_bien_uso' => 'Id Bien Uso',
        ];
    }
    public function getSeccion(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_area']);
    }
    
    public function getRubro(){
        return $this->hasOne(PatrimonioRubro::class, ['id'=>'id_rubro']);
    }
    public function getEstado(){
        return $this->hasOne(PatrimonioEstadosFormularios::class, ['id'=> 'id_estado_formulario']);
    }
    public function getStrRubro(){
        return $this->codigo_presupuestario.'.'.$this->sub_division.' - '.$this->denominacion;
    }
    // public function getBien(){
    //     return $this->hasMany(BienUso::class, ['id_seccion_bien'=>'id_area']);
    // }
}