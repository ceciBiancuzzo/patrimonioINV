<?php

namespace patrimonio\models;

use Yii;

/**
 * This is the model class for table "patrimonio.bien_uso_garantia".
 *
 * @property int $id Identificador de los detalles de garantia del bien.
 * @property int $id_bien_uso Referencia al bien de uso al que pertenecen los datos de garantia.
 * @property string $empresa Empresa que brinda el servicio.
 * @property int $periodo_garantia Periodo de duración de la garantia.
 * @property string $documento_respaldatorio Datos del documento que contiene la garantia
 * @property string $observaciones Observaciones a la garantia.
 * @property int $id_usuario_carga Datos de auditoria, usuario que cargo el campo.
 * @property int $id_usuario_baja Datos de auditoria, usuario que dio de baja el campo.
 * @property int $id_usuario_modificacion Datos de auditoria, usuario que modifico el campo.
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property string $fecha_inicio Fecha de inicio de la auditoria.
 * @property string $fecha_fin Fecha del fin de la auditoria.
 */
class BienUsoGarantia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.bien_uso_garantia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bien_uso'], 'required'],
            [['id_bien_uso', 'periodo_garantia', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_bien_uso', 'periodo_garantia', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'integer'],
            [['fecha_carga', 'fecha_baja', 'fecha_modificacion', 'fecha_inicio', 'fecha_fin'], 'safe'],
            [['empresa', 'documento_respaldatorio', 'observaciones'], 'string', 'max' => 255],
            // [['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_bien_uso' => 'Id Bien Uso',
            'empresa' => 'Empresa',
            'periodo_garantia' => 'Periodo Garantia',
            'documento_respaldatorio' => 'Documento Respaldatorio',
            'observaciones' => 'Observaciones',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
        ];
    }
    public function getActa(){
        return $this->hasOne(ActaRecepcionDetalle::class, ['id_bien_uso'=>'id']);
    }
}
