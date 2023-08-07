<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.usuarios_externos".
 *
 * @property int $id
 * @property int $id_persona
  * @property int $id_dependencia
 * @property int $fecha_modificacion
 * @property int $id_usuario_carga
 * @property int $id_usuario_modificacion
 *  @property int $fecha_baja
 * @property int $id_usuario_baja
 * @property int $fecha_carga
 * @property string $nombre_usuario
 * @property string $apellido_usuario
 * @property int $dni
 * @property int $telefono
 */
class PatrimonioUsuariosExternos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.usuarios_externos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['id'], 'required'],
           // [['id'], 'default', 'value' => null],
            [['id','id_usuario_carga','id_usuario_modificacion','id_persona','id_dependencia','dni','telefono'], 'integer'],
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
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'id_usuario_carga' => 'Id Usuario Carga',
            'nombre_usuario' => 'Usuario',
            'id_dependencia' => 'Área',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',

        ];
    }
    public function getStrArea(){
        return $this->hasOne(PatrimonioDependencia::class, ['id'=>'id_dependencia']);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> aprobacion_bodega-gerFinal
