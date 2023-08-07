<?php

namespace patrimonio\models;

use Yii;

/**
 * This is the model class for table "patrimonio.tecnico".
 *
 * @property int $id
 * @property int $legajo Numero de legajo perteneciente al tecnico
 * @property int $cuil Numero de CUIL perteneciente al tecnico
 * @property int $tarjeta
 * @property string $nombre Nombre del tecnico
 * @property string $apellido Apellido del tecnico
 * @property int $estado 
 */
class Tecnico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.tecnico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['legajo'], 'required'],
            [['legajo', 'cuil', 'tarjeta', 'estado '], 'default', 'value' => null],
            [['legajo', 'cuil', 'tarjeta', 'estado '], 'integer'],
            [['nombre', 'apellido'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'legajo' => 'Legajo',
            'cuil' => 'Cuil',
            'tarjeta' => 'Tarjeta',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'estado ' => 'Estado',
        ];
    }
}
