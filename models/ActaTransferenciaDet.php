<?php

namespace patrimonio\models;
use\patrimonio\parametros\PatrimonioCondicionBien;

use Yii;

/**
 * This is the model class for table "patrimonio.acta_transferencia_det".
 *
 * @property int $id
 *  @property int $id_cab Hace referencia a la cabecera de la transferencia.
 * @property int $id_bien_uso Hace referencia al bien de uso que va a ser transferido.
 * @property string $observaciones Texto libre para agregar notas por parte del Área de Patrimonio o el area que transfiere.
 * @property string $fecha_carga Datos de auditoria.
 * @property string $fecha_baja Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property int $id_usuario_carga Usuario que creo el formulario, datos de auditoria.
 * @property int $id_usuario_baja Usuario que elimino el formulario, datos de auditoria.
 * @property int $id_usuario_modificacion Usuario que modifico el formulario, datos de auditoria.
 * @property int $id_condicion Referencia  a la condición que se encuentra el bien que se transfiere.
 

 */
class ActaTransferenciaDet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.acta_transferencia_det';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['id', 'id_bien_uso'], 'required'],
            [['id_bien_uso','id_condicion'], 'required'],
           // [['id'], 'unique'],
            [[ 'id_cab','id_bien_uso', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_condicion'], 'default', 'value' => null],
            [[ 'id_cab','id_bien_uso', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'id_condicion'], 'integer'],
            [['fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],           
          
            [['observaciones'], 'string', 'max' => 2000],
            
            //  [['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
            //  [['id_condicion'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioCondicion::className(), 'targetAttribute' => ['id_condicion' => 'id']],
            //  [['id_agente_tecnico'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_agente_tecnico' => 'id']],
            //  [['id_agente_patrimonio'], 'exist', 'skipOnError' => true, 'targetClass' => PersonalAgente::className(), 'targetAttribute' => ['id_agente_patrimonio' => 'id']],
            // [['id_transf_cab'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioActaTransferenciaCab::className(), 'targetAttribute' => ['id_transf_cab' => 'id']],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cab'=>'id de la cabecera en detalle',
            'id_bien_uso' => 'Id Bien Uso',
            'observaciones' => 'Observaciones',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_condicion' => 'Id Condicion',
           
          
           
        ];
    }

    public function getBienUso(){
        return $this->hasOne(BienUso::class, ['id'=>'id_bien_uso']);
    }
    public function getCondicionBien(){
        return $this->hasOne(PatrimonioCondicionBien::class, ['id'=>'id_condicion']);
    }
    public function getCabecera(){
        return $this->hasOne(ActaTransferenciaCab::class, ['id'=>'id_cab']);
    }
}
