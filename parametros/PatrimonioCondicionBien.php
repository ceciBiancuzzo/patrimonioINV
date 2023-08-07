<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.condicion".
 *
 * @property int $id
 * @property string $descripcion hace referencia a las condiciones que se encuentra el bien de uso. bueno,malo,roto.
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_modificacion Datos de auditoria
 */
class PatrimonioCondicionBien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.condicion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['fecha_carga', 'fecha_baja', 'fecha_modificacion'], 'safe'],
            [['id_usuario_carga', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_usuario_carga', 'id_usuario_modificacion'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
        ];
    }
}
