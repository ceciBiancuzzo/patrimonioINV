<?php

namespace patrimonio\models;

use Yii;
use patrimonio\models\BienUso;
/**
 * This is the model class for table "patrimonio.imagen_bien".
 *
 * @property int $id
 * @property int $id_bien_uso
 * @property string $ruta_archivo
 * @property string $observaciones
 */
class PatrimonioImagenBien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.imagen_bien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         //   [['id'], 'required'],
            [['id_bien_uso'], 'integer'],
            [['ruta_archivo', 'observaciones','imagen_bien'], 'string'],
          //  [['id_bien_uso'], 'exist', 'skipOnError' => true, 'targetClass' => PatrimonioBienUso::className(), 'targetAttribute' => ['id_bien_uso' => 'id']],
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
            'ruta_archivo' => 'Ruta Archivo',
            'observaciones' => 'Observaciones',
            'imagen_bien'=> 'Imagen Bien'
        ];
    }
}
