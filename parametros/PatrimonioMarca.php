<?php

namespace patrimonio\parametros;
use Yii;

/**
 * This is the model class for table "patrimonio.marca".
 *
 * @property int $id
 * @property string $denominacion hace referencia a la marca que  va a tener un bien de uso.
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_baja usuario externo que elimino el formulario
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_modificacion Datos de auditoria
 */
class PatrimonioMarca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.marca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion'], 'string'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
            [['id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion'], 'integer'],
            [['denominacion'], 'filter', 'filter' => 'strtoupper'], //se convierte en mayúsculas
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
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
        ];
    }
}
