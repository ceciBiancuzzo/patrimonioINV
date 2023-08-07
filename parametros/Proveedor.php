<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.proveedor".
 *
 * @property int $id_usuario_modificacion Datos de auditoria
 * @property int $id_usuario_carga Datos de auditoria
 * @property int $id_usuario_baja Datos de auditoria
 * @property int $id_provincia Identificador de la provincia a la que pertenece el proveedor
 * @property int $id_localidad Identificador de la localidad a la que pertenece el proveedor
 * @property int $id_departamento Identificador del departamento al que pertenece el proveedor
 * @property int $id
 * @property string $fecha_modificacion Datos de auditoria
 * @property string $fecha_carga Datos de auditoria
 * @property string $fecha_baja Datos de auditoria
 * @property string $fax Numero de fax del proveedor 
 * @property string $email Correo electronico del proveedor
 * @property string $domicilio Domicilio del proveedor
 * @property string $denominacion Denominacion del proveedor
 * @property string $cuit Numero de CUIT del proveedor
 * @property string $condicioniva Tipo de condicion fiscal a la que se encuentra sujeto el proveedor
 * @property string $telefono Numero de telefono del proveedor
 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.proveedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario_modificacion', 'id_usuario_carga', 'id_usuario_baja', 'id_provincia', 'id_localidad', 'id_departamento'], 'default', 'value' => null],
            [['id_usuario_modificacion', 'id_usuario_carga', 'id_usuario_baja', 'id_provincia', 'id_localidad', 'id_departamento'], 'integer'],
            [['fecha_modificacion', 'fecha_carga', 'fecha_baja'], 'safe'],
            [['telefono'], 'string'],
            [['fax', 'email', 'domicilio', 'denominacion', 'cuit', 'condicioniva'], 'string', 'max' => 255],
            // [['id_departamento'], 'exist', 'skipOnError' => true, 'targetClass' => ParametrosDepartamentos::className(), 'targetAttribute' => ['id_departamento' => 'id']],
            // [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => ParametrosProvincias::className(), 'targetAttribute' => ['id_provincia' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_baja' => 'Id Usuario Baja',
            'id_provincia' => 'Id Provincia',
            'id_localidad' => 'Id Localidad',
            'id_departamento' => 'Id Departamento',
            'id' => 'ID',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_carga' => 'Fecha Carga',
            'fecha_baja' => 'Fecha Baja',
            'fax' => 'Fax',
            'email' => 'Email',
            'domicilio' => 'Domicilio',
            'denominacion' => 'Denominacion',
            'cuit' => 'Cuit',
            'condicioniva' => 'Condicioniva',
            'telefono' => 'Telefono',
        ];
    }
}
