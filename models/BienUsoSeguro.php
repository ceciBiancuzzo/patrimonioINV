<?php

namespace patrimonio\models;

use Yii;

/**
 * This is the model class for table "patrimonio.bien_uso_seguro".
 *
 * @property int $id
 * @property string $empresa Empresa a la que pertenece el seguro del bien
 * @property int $numero_poliza Numero de poliza del seguro del bien
 * @property string $forma_pago Forma de pago del seguro del bien
 * @property string $prima Prima del seguro.
 * @property int $importe Importe del seguro del bien
 * @property string $condiciones Condicion del bien 
 * @property string $fecha_inicio Fecha de inicio de la cobertura del seguro
 * @property string $fecha_fin Fecha de finalizacion de la cobertura del seguro
 * @property int $id_bien_uso Identificador del bien de uso
 * @property int $id_usuario_carga Datos de auditoria, usuario que cargo el campo.
 * @property int $id_usuario_modificacion Datos de auditoria, usuario que modifico el campo.
 * @property int $id_usuario_baja Datos de auditoria, usuario que dio de baja el campo.
 * @property string $fecha_carga Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property string $fecha_baja Datos de auditoria.
 */
class BienUsoSeguro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.bien_uso_seguro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa', 'forma_pago', 'prima', 'condiciones'], 'string'],
            [['numero_poliza', 'importe', 'id_bien_uso'], 'default', 'value' => null],
            [['id_bien_uso','numero_poliza', 'importe', 'id_bien_uso'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            //[['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'empresa' => 'Empresa',
            'numero_poliza' => 'Numero Poliza',
            'forma_pago' => 'Forma Pago',
            'prima' => 'Prima',
            'importe' => 'Importe',
            'condiciones' => 'Condiciones',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'id' => 'ID',
            'id_bien_uso' => 'Id Bien Uso',
        ];
    }
}
