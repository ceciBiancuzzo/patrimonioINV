<?php

namespace patrimonio\models;
use patrimonio\parametros\Proveedor;
use gestion_personal\models\PersonalAgente;
use patrimonio\parametros\PatrimonioCondicionBien;

use Yii;

/**
 * This is the model class for table "patrimonio.acta_recepcion_det".
 *
 * @property int $id
 * @property int $cantidad Cantidad del producto que se esta recepcionando 
 * @property int $id_proveedor Referencia al proveedor del producto
 * @property string $informe_tecnico En caso de haber algun comentario por parte de los tecnicos que han participado en la recepción del bien de uso
 * @property string $fecha_carga datos de auditoria
 * @property string $fecha_baja datos de auditoria
 * @property string $fecha_modificacion datos de auditoria
 * @property int $id_usuario_carga Usuario que creo el formulario, datos de auditoria
 * @property int $id_usuario_baja usuario que elimino el formulario, datos de auditoria
 * @property int $id_usuario_modificacion Usuario que modifico el formulario,datos de auditoria
 * @property int $id_bien_uso Referencia al bien de uso que forma parte del acta
 * @property bool $necesidad_aprobacion Booleano que establece si la aprobación es o no necesaria y habilita la selección de los técnicos pra el caso
 * @property int $id_cab Referencia a la recepción cabecera
 * @property int $id_area_tecnica Area encargada de la revisión del bien en caso de la necesidad de su aprobación
 * @property string $garantia Periodo de garantia del bien
 * @property int $tecnico_externo Establece la necesidad o no de un técnico externo al instituto
 * @property string $comentario Comentarios sobre la aprobación o rechazo de la revisión
 * @property int $renglon Referido al renglon de la orden de compra del bien
 * @property int $nro_detalle El numero del detalle que lo va a vincular con el bien

 */
class ActaRecepcionDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.acta_recepcion_det';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cantidad', 'id_proveedor', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_bien_uso',
             'id_cab'], 'default', 'value' => null],
            [['cantidad', 'id_proveedor', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_bien_uso','id_condicion',
              'id_cab','renglon','nro_detalle'], 'integer'],
            [['id_bien_uso','id_proveedor','cantidad', 'garantia','necesidad_aprobacion'], 'required'],
            [['fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['necesidad_aprobacion'], 'boolean'],
            [['informe_tecnico'], 'string', 'max' => 2000],
            [['cantidad'], 'controlCantidad'],
         ];
    }

    /**
     * {@inheritdoc} 
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cantidad' => 'Cantidad',
            'id_proveedor' => 'Id Proveedor',
            'informe_tecnico' => 'Informe Tecnico',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_bien_uso' => 'Id Bien Uso',
            'id_condicion' => 'Id Condicion',
            'necesidad_aprobacion' => 'Necsidad de aprobacion',
            'id_cab' => 'Id Cab',
            'garantia' => 'Garantia',
            'renglon' => 'Renglon'
        ];
    }

    public function getBienUso(){
        return $this->hasOne(BienUso::class, ['id'=>'id_bien_uso']);
    }

    public function getCondicionBien(){
        return $this->hasOne(PatrimonioCondicionBien::class, ['id'=>'id_condicion']);
    }

    public function getProveedor(){
        return $this->hasOne(Proveedor::class, ['id'=>'id_proveedor']);
    }

    public function getPersonalAgente(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_agente_tecnico']);
    }

    public function getCabecera(){
        return $this->hasOne(ActaTransferenciaCab::class, ['id'=>'id_cab']);

    }
    public function controlCantidad($attribute, $params, $validator = NULL){
        Yii::trace("hola");
        
            if($this->cantidad === 0){
            $this->addError($attribute,'mal');
        }
    }
}