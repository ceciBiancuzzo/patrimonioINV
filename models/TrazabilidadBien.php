<?php

namespace patrimonio\models;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\models\ActaRecepcionCabecera;
use gestion_personal\models\PersonalAgente;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\parametros\PatrimonioArea;
use patrimonio\parametros\PatrimonioDependencia;

use Yii;

/**
 * This is the model class for table "patrimonio.trazabilidad_bien".
 *
 * @property int $id Identificador
 * @property int $id_estado Identificador del estado del bien
 * @property int $id_condicion Identificador de la condicion del bien
 * @property int $id_bien_uso Identificador del bien de uso
 * @property int $id_usuario_actual Identificador del usuario que posee actualmente el bien de uso
 * @property int $id_transferencia Identificador del acta de transferencia del bien de uso
 * @property string $fecha_alta Fecha de carga del campo
 * @property int $id_recepcion Identificador del acta de recepcion del bien de uso
 * @property string $comentario Comentarios varios sobre el bien de uso 
 * @property string $fecha_baja Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property string $fecha_carga Datos de auditoria.
 * @property int $id_usuario_carga Datos de auditoria.
 * @property int $id_usuario_baja Datos de auditoria.
 * @property int $id_usuario_modificacion Datos de auditoria.
 * @property int $id_area_actual Hace referencia al área en la que se encuentra el bien de uso.
 * @property int $id_area_anterior Hace referencia al área en la que estaba anteriormente el bien de uso.
 * @property int $id_estado_formulario
 */
 
class TrazabilidadBien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.trazabilidad_bien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado', 'id_condicion', 'id_bien_uso', 'id_usuario_actual','id_area_actual','id_area_anterior' ,'id_transferencia', 'id_recepcion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_estado_formulario','id_estado', 'id_condicion', 'id_bien_uso', 'id_usuario_actual','id_area_actual','id_area_anterior', 'id_transferencia', 'id_recepcion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'integer'],
            [['fecha_alta', 'fecha_baja', 'fecha_modificacion', 'fecha_carga'], 'safe'],
            [['comentario'], 'string', 'max' => 2000],
            // [['id_recepcion'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioActaRecepcionCab::className(), 'targetAttribute' => ['id_recepcion' => 'id']],
            // [['id_transferencia'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioActaTransferenciaCab::className(), 'targetAttribute' => ['id_transferencia' => 'id']],
            // [['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
            // [['id_condicion'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioCondicion::className(), 'targetAttribute' => ['id_condicion' => 'id']],
            // [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioEstadoInterno::className(), 'targetAttribute' => ['id_estado' => 'id']],
            // [['id_solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioSolicitudCab::className(), 'targetAttribute' => ['id_solicitud' => 'id']],
            // [['id_usuario_actual'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_usuario_actual' => 'id']],
            // [['id_usuario_anterior'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_usuario_anterior' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_estado' => 'Id Estado',
            'id_condicion' => 'Id Condicion',
            'id_bien_uso' => 'Id Bien Uso',
            'id_usuario_actual' => 'Id Usuario Actual',
            'id_transferencia' => 'Id Transferencia',
            'fecha_alta' => 'Fecha Alta',
            'id_recepcion' => 'Id Recepcion',
            'comentario' => 'Comentario',
            'id_area_actual'=> 'Area actual',
            'id_area_anterior' => 'Area anterior',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_carga' => 'Fecha Carga',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
        ];
    }
    // public function getMarcas(){
    //     return $this->hasOne(PatrimonioMarca::class, ['id'=>'id_marca']);
    // }
    // public function getDetallesContables(){
    //     return $this->hasOne(BienUsoContables::class, ['id_bien_uso'=>'id']);
    // }
    // public function getDetallesGarantia(){
    //     return $this->hasOne(BienUsoGarantia::class, ['id_bien_uso'=>'id']);
    // }
    // public function getDetallesSeguro(){
    //     return $this->hasOne(BienUsoSeguro::class, ['id_bien_uso'=>'id']);
    // }
    // public function getPartida(){
    //     return $this->hasOne(PatrimonioPartida::class, ['id'=>'id_partida']);
    // }
    public function getRubro(){
        return $this->hasOne(PatrimonioRubro::class, ['id'=>'id_rubro']);
    }
    public function getCondicion(){
        return $this->hasOne(PatrimonioCondicionBien::class, ['id'=>'id_condicion']);
    }
    public function getEstadoInterno(){
        return $this->hasOne(PatrimonioEstadoInterno::class, ['id'=>'id_estado']);
    }
    public function getBienUso(){
        return $this->hasOne(BienUso::class, ['id'=>'id_bien_uso']);
    }
    public function getStrBien(){
        return $this->tipo_bien.'-'.$this->modelo.'-'.$this->nro_inventario;
    }
    public function getUsuarioAsignado(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_actual']);
    }
    


// public function getUsuarioTransferencia(){
//     return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_anterior']);
// }

public function getUsuarioRecepciona(){
    return $this->hasOne(PersonalAgente::class, ['id'=>'id_usuario_actual']);
}
// public function getStrBien(){
//     return $this->tipo_bien.'-'.$this->modelo.'-'.$this->nro_inventario;
// }

public function getAreaTransferencia(){
    return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_area_anterior']);
}
public function getAreaRecepciona(){
    return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_area_actual']);
}

public function getNroActaRecepcion(){
    return $this->hasOne(ActaRecepcionCabecera::class, ['id'=>'id_recepcion']);
}

public function getNroActaTransferencia(){
    return $this->hasOne(ActaTransferenciaCab::class, ['id'=>'id_transferencia']);
}
}
