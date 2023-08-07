<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.estado_interno".
 *
 * @property int $id
 * @property string $denominacion describe el estado en el que se encuentra el bien de uso.
 * @property string $descripcion
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_baja Datos de auditoria
 * @property int $id_usuario_modificacion Usuario externo que modifico el formulario
 */
class PatrimonioEstadoInterno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.estado_interno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion'], 'required'],
            [['fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'integer'],
            [['denominacion', 'descripcion'], 'string', 'max' => 200],
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
            'descripcion' => 'Descripcion',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
        ];
    }
}
