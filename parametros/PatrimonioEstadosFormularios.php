<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.estados_formularios".
 *
 * @property int $id
 * @property string $descripcion
  * @property string $fecha_carga
 * @property string $fecha_modificacion
 * @property int $id_usuario_carga
 * @property int $id_usuario_modificacion
 */
class PatrimonioEstadosFormularios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.estados_formularios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['id'], 'required'],
           // [['id'], 'default', 'value' => null],
            [['id','id_usuario_carga','id_usuario_modificacion'], 'integer'],
            [['descripcion'], 'string'],
            [[ 'fecha_carga', 'fecha_modificacion'], 'safe'],
            [['id'], 'unique'],
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
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',

        ];
    }
}
