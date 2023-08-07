<?php

namespace patrimonio\parametros;
use gestion_personal\models\PersonalAgente;
use Yii;

/**
 * This is the model class for table "patrimonio.encargado_patrimonial".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $fecha_carga
 * @property string $fecha_modificacion
 * @property string $fecha_baja
 * @property int $id_usuario_carga
 * @property int $id_usuario_modificacion
 * @property int $id_usuario_baja
 * @property int $id_usuario2
 */
class PatrimonioEncargadoPatrimonial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.encargado_patrimonial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'default', 'value' => null],
            [['id_usuario','id_usuario2', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'id_usuario2' => 'Id Usuario2',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_baja' => 'Fecha Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
        ];
    }


}