<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.area".
 *
 * @property int $id
 * @property string $denominacion Nombre del area.
 * @property string $fecha_baja Datos de auditoria.
 * @property string $fecha_carga Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property int $id_delegacion Identifica la delegación del inscripto
 * @property int $id_usuario_carga Usuario que creo el formulario, datos de auditoria.
 * @property int $id_usuario_baja Usuario que elimino el formulario, datos de auditoria.
 * @property int $id_usuario_modificacion Usuario que modifico el formulario, datos de auditoria.
 * @property int $codigo_dependencia
 */
class PatrimonioArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.dependencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion', 'codigo_dependencia'], 'required'],
            [['fecha_baja', 'fecha_carga', 'fecha_modificacion'], 'safe'],
            [['id_delegacion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'codigo_dependencia'], 'default', 'value' => null],
            [['id_delegacion', 'id_usuario_carga', 'id_usuario_baja', 'id_usuario_modificacion', 'codigo_dependencia'], 'integer'],
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
            'fecha_baja' => 'Fecha Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_delegacion' => 'Id Delegacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'codigo_dependencia' => 'Codigo Dependencia',
        ];
    }
}
