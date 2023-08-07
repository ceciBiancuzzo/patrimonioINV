<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.tipo_movimiento".
 *
 * @property int $id
 * @property string $denominacion
 * @property string $descripcion
 */
class PatrimonioTipoMovimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.tipo_movimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['denominacion', 'descripcion'], 'string'],
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
            'descripcion' => 'Descripcion',
        ];
    }
}
