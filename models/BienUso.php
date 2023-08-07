<?php

namespace patrimonio\models;
use patrimonio\parametros\PatrimonioPartida;
use patrimonio\parametros\PatrimonioRubro;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\parametros\PatrimonioMarca;


use gestion_personal\models\PersonalAgente;
use Yii;

/**
 * This is the model class for table "patrimonio.bien_uso".
 * @property int $id Identificador del bien de uso.
 * @property int $id_acta_recepcion_definitiva Referencia al acta de recepción que documento la recepción del bien.
 * @property string $descripcion_bien Descripción del bien de uso, con sus distintas características no incluidas en otros atributos.
 * @property string $fecha_baja Datos de auditoria. 
 * @property string $fecha_carga Datos de auditoria. 
 * @property string $fecha_modificacion Datos de auditoria. 
 * @property int $id_acta_transferencia Referencia al último acta de transferencia en la que estuvo involucrada el bien.
 * @property int $id_marca Referencia a la marca del bien.
 * @property int $id_rubro Referencia al rubro al que pertenece el bien.
 * @property int $id_usuario_carga Usuario que cargo el campo, datos de auditoria.
 * @property int $id_usuario_modificacion Usuario que modifico el formulario, datos de auditoria.
 * @property string $modelo Modelo del bien de uso.
 * @property string $nro_serie  Numero de serie del bien de uso.
 * @property int $id_condicion Referencia a la ultimo condición del bien de uso.
 * @property int $id_estado_interno Referencia al ultimo estado que tiene el bien.
 * @property int $id_usuario_baja Usuario que dio de baja el campo, datos de auditoria.
 * @property int $id_usuario_bien Usuario que dio de baja el campo, datos de auditoria.
 * @property int $nro_inventario Numero de inventario, que se asigna una vez cargada el acta de recepción.
 * @property string $codigo_item_catalogo Codigo de la factura del bien.
 * @property string $observaciones Cualquier tipo de comentario u observación referida al bien
 * @property string $tipo_identificacion Tipo de identificación del bien (chapa, tinta, etc)
 * @property string $tipo_bien Hace referencia a una descripción resumida del nombre del bien de uso.
 * @property string $ubicacion_bien Referencia a donde se encuentra el bien, sea en caso de reparación u otra ocasión
 * @property string $precio_origen Precio de origen del bien
 * @property bool $propiedad_bien Indicar si el bien pertenece al instituto o un tercero true =instituto, false = tercero
 * @property int $cantidad Cantidad que se ha recibido de ese mismo bien
 * @property bool $faltante Indica en caso que en el informe patrimonial el bien se haya declarado faltante
 * @property int $vida_util
 * @property int $vida_util_transcurrida
 * @property string $amortizacion_anual_acumulada
 * @property string $amortizacion_anual
 * @property string $valor_residual
 * @property string $valor_rezago
 * @property int $anio_alta
 * @property bool $amortizable
 * @property int $id_dependencia
 * @property string $acto_admin
 * @property string $obvs_admin
 * @property bool $necesidad_aprobacion
 * @property int $tecnico_revision1
 * @property int $tecnico_revision2
 * @property string $comentario_revision
 * @property int $aprobacion
 * @property string $nro_ordencompra
 * @property int $renglon_oc
 * @property int $codigo_doc_alta
 * @property int $n_acta_recepcion
 * @property string $fecha_acta
 * @property int $id_detalle_acta
 * @property boolean $transf_actual campo para verificar si el bien esta en una transferencia pendiente
 * @property string $fecha_baja_definitiva




 */
class BienUso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.bien_uso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_acta_recepcion_definitiva', 'id_acta_transferencia', 'cantidad','id_usuario_bien','id_marca', 'id_rubro', 'id_usuario_carga', 'id_usuario_modificacion',
             'nro_serie', 'id_condicion', 'id_estado_interno', 'id_usuario_baja'], 'default', 'value' => null],               
            [['id_acta_recepcion_definitiva', 'id_acta_transferencia','id_usuario_bien', 'id_marca', 'id_rubro', 'id_usuario_carga', 'id_usuario_modificacion',  'id_condicion', 
            'id_estado_interno', 'id_usuario_baja','tecnico_revision1','tecnico_revision2','id_detalle_acta','anio_alta','vida_util_transcurrida'], 'integer'],
            [['id_rubro','id_dependencia', 'tipo_bien',], 'required'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion','comentario_revision','obvs_admin','acto_admin'], 'safe'],
            [['precio_origen', 'amortizacion_anual','valor_residual','valor_rezago','amortizacion_anual_acumulada'], 'number'],
            [['propiedad_bien','amortizable'], 'boolean'],
            [['necesidad_aprobacion'], 'boolean'],
            [['tipo_bien','modelo','nro_serie','descripcion_bien','tipo_identificacion'], 'filter', 'filter' => 'strtoupper'],    // se convierte en Mayúsculas

            // [['id_acta_recepcion_definitiva'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioActaRecepcionCab::className(), 'targetAttribute' => ['id_acta_recepcion_definitiva' => 'id']],
            // [['id_acta_transferencia'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioActaTransferenciaCab::className(), 'targetAttribute' => ['id_acta_transferencia' => 'id']],
            // [['id_condicion'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioCondicion::className(), 'targetAttribute' => ['id_condicion' => 'id']],
            // [['id_marca'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioMarca::className(), 'targetAttribute' => ['id_marca' => 'id']],
            // [['id_rubro'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioRubro::className(), 'targetAttribute' => ['id_rubro' => 'id']],
            // [['id_trazabilidad_del_bien'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioTrazabilidadBien::className(), 'targetAttribute' => ['id_trazabilidad_del_bien' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_acta_recepcion_definitiva' => 'Id Acta Recepcion Definitiva',
            'descripcion_bien' => 'Descripcion Bien',
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id' => 'ID',
            'id_acta_transferencia' => 'Id Acta Transferencia',
            'id_marca' => 'Id Marca',
            'id_rubro' => 'Id Rubro',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'modelo' => 'Modelo',
            'nro_serie' => 'Número de serie',
            'id_condicion' => 'Id Condicion',
            'id_estado_interno' => 'Id Estado Interno',
            'id_usuario_baja' => 'Id Usuario Baja',
            'nro_inventario' => 'Número de inventario',
            'codigo_item_catalogo' => 'Codigo Item Catalogo',
            'observaciones' => 'Observaciones',
            'tipo_identificacion' => 'Tipo de identificación',
            'tipo_bien' =>'Tipo de bien',
            'ubicacion_bien'=>'Ubicación del bien',
            'propiedad_bien' => 'Propiedad del bien',
            'obvs_admin'=>'Observacion Administrativa',
            'acto_admin'=>'Acto administrativo',
            'id_detalle_acta'=>'id detalle',
            'nro_oc' => 'Numero de Orden de Compra',
            'renglon_oc' => 'Renglon de Orden de Compra',
            'cod_doc_alta' => 'Codigo de Documento de Alta',
            'n_acta_rec_def' => 'Numero de Acta de Recepcion Defintiiva'
        ];
    }
 
    public function getMarcas(){
        return $this->hasOne(PatrimonioMarca::class, ['id'=>'id_marca']);
    }
    public function getDetallesContables(){
        return $this->hasOne(BienUsoContables::class, ['id_bien_uso'=>'id']);
    }
    public function getDetallesGarantia(){
        return $this->hasOne(BienUsoGarantia::class, ['id_bien_uso'=>'id']);
    }
    public function getDetallesSeguro(){
        return $this->hasOne(BienUsoSeguro::class, ['id_bien_uso'=>'id']);
    }
 
    public function getRubro(){
        return $this->hasOne(PatrimonioRubro::class, ['id'=>'id_rubro']);
    }
    public function getCondicion(){
        return $this->hasOne(PatrimonioCondicionBien::class, ['id'=>'id_condicion']);
    }
    public function getEstadoInterno(){
        return $this->hasOne(PatrimonioEstadoInterno::class, ['id'=>'id_estado_interno']);
    }
    public function getDependencia(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_dependencia']);
    }

    public function getStrBien(){
        if($this->marcas){
            return $this->nro_inventario.' - '.$this->tipo_bien.' - '.$this->modelo.' - '.$this->marcas->denominacion.' - '.$this->nro_serie;
        }else{
            return $this->nro_inventario.' - '.$this->tipo_bien.' - '.$this->modelo.' - '.$this->nro_serie;

        }
    }
    public function getStrInforme(){
        if($this->marcas){
            return $this->tipo_bien.' - '.$this->descripcion_bien.' - '.$this->modelo.' - '.$this->marcas->denominacion.' - '.$this->nro_serie;
        }else{
            return $this->tipo_bien.' - '.$this->descripcion_bien.' - '.$this->modelo.' - '.$this->nro_serie;

        }
    }

    public function getUsuarioAsignado(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_bien']);
    }
   
}
