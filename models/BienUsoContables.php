<?php

namespace patrimonio\models;

use Yii;

/**
 * This is the model class for table "patrimonio.bien_uso_contables".
 *
 * @property int $id Identificador de los datos contables del bien.
 * @property int $id_bien_uso Referencia al bien de uso al que corresponden los detalles.
 * @property int $ejercicio Ejercicio contable en el que se devengo el bien.
 * @property string $tipo_adquisicion Si se trata de una compra presupuestaria, de caja chica, etc
 * @property string $motivo Motivo por el que se adquirió el bien.
 * @property string $dominio Dominio del bien.
 * @property string $submotivo Submotivo de adquisición del bien.
 * @property string $entidad_cedente Entidada que ha cedido el bien.
 * @property string $observaciones Observaciones sobre los detalles contables.
 * @property int $id_usuario_carga Datos de auditoria, usuario que cargo el campo.
 * @property int $id_usuario_modificacion Datos de auditoria, usuario que modifico el campo.
 * @property int $id_usuario_baja Datos de auditoria, usuario que dio de baja el campo.
 * @property string $fecha_carga Datos de auditoria.
 * @property string $fecha_modificacion Datos de auditoria.
 * @property string $fecha_baja Datos de auditoria.
 */
class BienUsoContables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.bien_uso_contables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['id_bien_uso'], 'required'],
            [['id_bien_uso', 'ejercicio', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'default', 'value' => null],
            [['id_bien_uso', 'ejercicio', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['observaciones'], 'string'],
            [['fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
            [['tipo_adquisicion', 'motivo', 'dominio', 'submotivo', 'entidad_cedente'], 'string', 'max' => 255],
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
            'ejercicio' => 'Ejercicio',
            'tipo_adquisicion' => 'Tipo Adquisicion',
            'motivo' => 'Motivo',
            'dominio' => 'Dominio',
            'submotivo' => 'Submotivo',
            'entidad_cedente' => 'Entidad Cedente',
            'observaciones' => 'Observaciones',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_baja' => 'Fecha Baja',
        ];
    }
    public function getCabecera(){
        return BienUso::find()->one($this->id_bien_uso);
    }
}
