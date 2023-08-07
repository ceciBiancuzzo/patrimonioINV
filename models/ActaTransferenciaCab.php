<?php

namespace patrimonio\models;
use patrimonio\parametros\PatrimonioArea;

use gestion_personal\models\PersonalAgente;
use Yii;
use gestion_personal\models\PersonalOrganigrama;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\models\BienUso;
use common\models\helpers\AppHelpers;
/**
 * This is the model class for table "patrimonio.acta_transferencia_cab".
 *
 * @property int $id
 * @property string $fecha_recepcion es la fecha en la que un área recepciona un bien de uso en una transferencia de bienes.
 * @property string $fecha_transferencia Es la fecha en la que un área transfiere un bien de uso a otra.
 * @property string $observaciones Texto libre para agregar notas por parte del Área de Patrimonio o  por quienes realizan la transferencia.
 * @property string $fecha_carga Datos de auditoria.
 * @property string $fecha_baja Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property int $id_usuario_carga Usuario que creo el formulario, datos de auditoria.
 * @property int $id_usuario_baja Usuario que elimino el formulario, datos de auditoria.
 * @property int $id_usuario_modificacion Usuario que modifico el formulario, datos de auditoria.
 * @property int $nro_acta_transferencia Hace referencia a un numero autoincremental que diferencia a las distintas transferencias.
 * @property int $id_estado_formulario. Hace referencia a los distintos estados que puede tener un formulario.
 * @property int $tipo_solicitud
 * @property int $id_dependencia
 * @property int $id_dependencia2
 * @property int $id_usuario_transfrencia
 * @property int $id_usuario_recepcion

 */
class ActaTransferenciaCab extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.acta_transferencia_cab';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [[  'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [[   'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'nro_acta_transferencia','id_estado_formulario','id_departamento2','tipo_solicitud','id_dependencia','id_dependencia2'], 'integer'],
            [['fecha_recepcion', 'fecha_transferencia', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['observaciones'], 'string'],
            [['id_dependencia','id_dependencia2','tipo_solicitud'] ,'required']
          //   [['fecha_transferencia','id_usuario_transferencia','id_usuario_recepcion'], 'required'],
            // [['id_area_transferencia'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioArea::className(), 'targetAttribute' => ['id_area_transferencia' => 'id']],
            // [['id_area_recepcion'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioArea::className(), 'targetAttribute' => ['id_area_recepcion' => 'id']],
            // [['id_usuario_transferencia'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_usuario_transferencia' => 'id']],
            // [['id_usuario_recepcion'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_usuario_recepcion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'id_area_transferencia' => 'Id Area Transferencia',
           // 'id_area_recepcion' => 'Id Area Recepcion',
       
           
            'fecha_recepcion' => 'Fecha Recepcion',
            'fecha_transferencia' => 'Fecha Transferencia',
            'observaciones' => 'Observaciones',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'nro_acta_transferencia' => 'Nro Acta Transferencia',
            'id_estado_formulario'=>'Id estado formulario',
            'id_departamento2'=>'Departamento2',
            'id_dependencia'=>'Area de Dependencia que Transfiere',
            'id_dependencia2'=>'Are de Dependencia que recepciona'
        ];
    }

    public function getDetalles(){
        return $this->hasMany(ActaTransferenciaDet::class, ['id_cab'=>'id']);
    }

    public function getAreaTransferencia(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_dependencia']);
    }
    public function getAreaRecepciona(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_dependencia2']);
    }
    public function getUsuarioTransferencia(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_transferencia']);
    }
    public function getUsuarioRecepciona(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_recepcion']);
    }
    public function getCantidadDias(){
        $fechaCreacion = $this->fecha_carga;
        $fechaHoy = date('Y-m-d');
        $subfecha = substr($fechaCreacion,0,-8);
        $fechaNormal = AppHelpers::cambiaFechaANormal($subfecha);
           
        $fechaHoyNormal = AppHelpers::cambiaFechaANormal($fechaHoy);
        $dif_dias = floor(AppHelpers::comparaFechas($fechaHoyNormal,$fechaNormal))/(3600 * 24);

        return round($dif_dias) ." dias";
    }


    //
  
}