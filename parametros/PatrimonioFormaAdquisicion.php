<?php

namespace patrimonio\parametros;

use Yii;

/**
 * This is the model class for table "patrimonio.forma_adquisicion".
 *
 * @property int $id
 * @property string $forma_adquisicion
 * @property int $fecha_baja
 */
class PatrimonioFormaAdquisicion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.forma_adquisicion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['denominacion'], 'string'],
            [['fecha_baja'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denominacion' => 'Forma Adquisicion',
        ];
    }
}
