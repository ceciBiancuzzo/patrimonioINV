<?php

namespace patrimonio\models;

use Yii;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioFormaAdquisicion;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\models\PatrimonioComision;



/**
 * This is the model class for table "patrimonio.acta_recepcion_cab".
 *
 * @property int $id Numero de identificador 
 * @property string $nro_acta hace referencia al número de acta de recepción definitiva.
 * @property string $orden_compra hace referencia a la licitación o pliego
 * @property string $fecha_acta hace referencia a la fecha en la que se firma el acta definitiva de el bien de uso.
 * @property string $fecha_carga datos de auditoria
 * @property string $fecha_baja datos de auditoria
 * @property string $fecha_modificacion datos de auditoria
 * @property int $id_usuario_baja usuario que elimino el formulario, datos de auditoria
 * @property int $id_usuario_carga Usuario que creo el formulario, datos de auditoria
 * @property int $id_usuario_modificacion Usuario que modifico el formulario, datos de auditoria
 * @property string $nro_expediente Referencia al numero de expediente de compra 
 * @property int $id_condicion identifica la condición en la que se encuentra el bien de uso 
 * @property string $id_forma_adquisicion Forma en que se realizo la compra (caja chica, compra directa, licitacion)
 * @property int $id_dependencia El id de la seccion que ha adquirido el bien
 * @property string $nro_gde Numero asignado al acta de recepcion una vez presentada
 * @property string $observacion_acta Observaciones al acta de recepcion
 * @property int $id_comision El id de la comision que aprueba la recepcion del bien


 * 
 */
class ActaRecepcionCabecera extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.acta_recepcion_cab';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion','id_forma_adquisicion'], 'default', 'value' => null],
            [['nro_acta', 'id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion','id_estado', 'id_forma_adquisicion', 'id_comision','id_dependencia'], 'integer'],
            [['id_forma_adquisicion', 'fecha_acta',], 'required'],
            [['observacion_acta'], 'string'],
            [['fecha_acta', 'fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['orden_compra', 'nro_expediente', 'nro_gde'], 'string', 'max' => 200],
            [['texto_acta'], 'string', 'max' => 2000]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nro_acta' => 'Nro Acta',
            'orden_compra' => 'Orden Compra',
            'fecha_acta' => 'Fecha Acta',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'nro_expediente' => 'Nro Expediente',
            'id_forma_adquisicion' => 'Forma Adquisicion',
            'id_dependencia'=>' Id dependencia',
            'texto_acta' => 'Texto acta',
            'id_estado' => 'Estado Acta Recepcion',
            'nro_gde' => 'Numero de GDE',
            'id_comision' => 'Comisión'
        ];
    }
    
    public function getDetalles(){
        return $this->hasMany(ActaRecepcionDetalle::class, ['id_cab'=>'id']);
    }
    
    public function getPersonalAgente(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_agente_tecnico']);
    }

    public function getFormaAdquisicion(){
        return $this->hasOne(PatrimonioFormaAdquisicion::class, ['id'=>'id_forma_adquisicion']);
    }

    public function getComision(){
        return $this->hasOne(PatrimonioComision::class, ['id'=>'id_comision']);
    }

    public function getPersonaComision1(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona1']);
    }

    public function getSeccion(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_dependencia']);
    }
}
