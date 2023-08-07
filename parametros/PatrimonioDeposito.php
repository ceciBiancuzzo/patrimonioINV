<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.deposito".
 *
 * @property int $id
 * @property string $denominacion Denominacion del deposito en el que se encuentra el bien de uso
 * @property int $id_delegacion
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_baja Datos de auditoria
 * @property int $id_usuario_modificacion Datos de auditoria
 */
class PatrimonioDeposito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.deposito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_delegacion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'default', 'value' => null],
            [['id_delegacion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion'], 'integer'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
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
            'id_delegacion' => 'Id Delegacion',
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
        ];
    }
}
