<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.partida".
 *
 * @property int $id 
 * @property string $codigo_partida Codigo de la partida en la cual esta el bien de uso
 * @property string $denominacion Denominacion de la partida en la cual se encuentra el bien de uso
 * @property string $fecha_baja Datos de auditoria
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_modificacion Datos de auditoria
 * @property int $id_usuario_baja Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_modificacion Datos de auditoria
 * @property int $nivel
 * @property int $idpartidapadre
 */
class PatrimonioPartida extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.partida';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion', 'fecha_carga', 'fecha_modificacion', 'id_usuario_carga', 'id_usuario_modificacion'], 'required'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
            [['id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion', 'nivel', 'idpartidapadre'], 'default', 'value' => null],
            [['id_usuario_baja', 'id_usuario_carga', 'id_usuario_modificacion', 'nivel', 'idpartidapadre'], 'integer'],
            [['codigo_partida', 'denominacion'], 'string', 'max' => 255],
            [['idpartidapadre'], 'exist', 'skipOnError' => true, 'targetClass' => AlmacenPartida::className(), 'targetAttribute' => ['idpartidapadre' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id ' => 'Id',
            'codigo_partida' => 'Codigo Partida',
            'denominacion' => 'Denominacion',
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'nivel' => 'Nivel',
            'idpartidapadre' => 'Idpartidapadre',
        ];
    }
}
