<?php

namespace patrimonio\parametros;
use gestion_personal\models\PersonalAgente;
use gestion_personal\models\PersonalOrganigrama;

use Yii;

/**
 * This is the model class for table "patrimonio.dependencia".
 *
 * @property int $id
 * @property string $denominacion Nombre del area.
 * @property int $codigo_dependencia
 * @property string $fecha_baja
 * @property string $fecha_carga
 * @property string $fecha_modificacion
 * @property int $id_usuario_carga
 * @property int $id_usuario_baja
 * @property int $id_usuario_modificacion
 * @property int $id_organigrama
 * @property int $id_encargado
 * @property int $id_encargado2
 * @property int $id_jefe
 * @property string $fecha_carga_encargado1
 * @property string $fecha_carga_encargado2
 * @property int $id_usuario_aprobacion
 * @property string $fecha_aprobacion
 * @property string $fecha_presentacion
 * @property int $id_usuario_presentacion
 * @property string $observaciones
 * @property string $observaciones_admin
 * @property int $id_estado_formulario
 * @property int $fecha_aprobacion
 * @property int $id_usuario_aprobacion
 * @property int $fecha_presentacion
 * @property int $id_usuario_presentacion 
 * @property int $sobrantes
 * @property int $fecha_modificacion_sobrantes
 * @property int $id_usuario_modificacion_sobrantes
 * @property int $id_usuario_modificacion_faltantes
 * @property string $fecha_modificacion_faltantes
 * @property int $id_usuario_rectificacion
 * @property int $fecha_rectificacion
 */
class PatrimonioDependencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.dependencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion'], 'required'],
            [['codigo_dependencia', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['codigo_dependencia', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion','id_organigrama','id_jefe','id_usuario_modificacion_faltantes','id_usuario_modificacion_sobrantes','id_usuario_rectificacion','id_usuario_presentacion','id_usuario_aprobacion'], 'integer'],
            [['fecha_baja', 'fecha_modificacion_faltantes', 'fecha_modificacion_sobrantes','fecha_rectificacion','fecha_carga', 'fecha_modificacion','fecha_presentacion','fecha_aprobacion'], 'safe'],
            [['denominacion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denominacion' => 'Denominacion',
            'codigo_dependencia' => 'Codigo Dependencia',
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_encargado' => 'Id Encargado',
            'id_encargado2' => 'Id Encargado 2',
        ];
    }
    public function getEncargado(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_encargado']);
    }

    public function getEncargado2(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_encargado2']);
    }
    public function getArea()
    {
        return $this->hasOne(PersonalOrganigrama::class, ['id' => 'id_organigrama']);
    }
    public function getEstado(){
        return $this->hasOne(PatrimonioEstadosFormularios::class, ['id'=> 'id_estado_formulario']);
    }
    public function getStrDependencia(){
        if($this->denominacion && $this->codigo_dependencia){
            return $this->codigo_dependencia.' - '.$this->denominacion;
        }else {
            return "Error";
        }
    }
    public function getStrJefe(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_jefe']);
    }

}

<<<<<<< HEAD
    


=======
    
>>>>>>> aprobacion_bodega-gerFinal
