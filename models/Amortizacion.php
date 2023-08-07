<?php

namespace patrimonio\models;

use Yii;

/**
 * This is the model class for table "patrimonio.amortizacion".
 *
 * @property int $id
 * @property string $amortizacion_anual
 * @property string $amortizacion_anual_acumulada
 * @property string $valor_residual
 * @property int $anio
 * @property string $r_431
 * @property string $r_432
 * @property string $r_433
 * @property string $r_434
 * @property string $r_435
 * @property string $r_436
 * @property string $r_437
 * @property string $r_438
 * @property string $r_439
 * @property string $fecha_carga
 * @property string $fecha_modificacion
 * @property string $fecha_baja
 * @property int $id_usuario_carga
 * @property int $id_usuario_modificacion
 * @property int $id_usuario_baja
 * @property string $r_431_acumulada
 * @property string $r_432_acumulada
 * @property string $r_433_acumulada
 * @property string $r_434_acumulada
 * @property string $r_435_acumulada
 * @property string $r_436_acumulada
 * @property string $r_437_acumulada
 * @property string $r_438_acumulada
 * @property string $r_439_acumulada
 * @property string $r_431_precio_origen
 * @property string $r_432_precio_origen
 * @property string $r_433_precio_origen
 * @property string $r_434_precio_origen
 * @property string $r_435_precio_origen
 * @property string $r_436_precio_origen
 * @property string $r_437_precio_origen
 * @property string $r_438_precio_origen
 * @property string $r_439_precio_origen
 * @property string $precio_origen_total
 * @property string $r_431_valor_residual
 * @property string $r_432_valor_residual
 * @property string $r_433_valor_residual
 * @property string $r_434_valor_residual
 * @property string $r_435_valor_residual
 * @property string $r_436_valor_residual
 * @property string $r_437_valor_residual
 * @property string $r_438_valor_residual
 * @property string $r_439_valor_residual
 * @property string $cantidad_bienes_amortizados
 * @property string $r_431_amortizacion_acum_anterior
 * @property string $r_432_amortizacion_acum_anterior
 * @property string $r_433_amortizacion_acum_anterior
 * @property string $r_434_amortizacion_acum_anterior
 * @property string $r_435_amortizacion_acum_anterior
 * @property string $r_436_amortizacion_acum_anterior
 * @property string $r_437_amortizacion_acum_anterior
 * @property string $r_438_amortizacion_acum_anterior
 * @property string $r_439_amortizacion_acum_anterior
 * @property string $amortizacion_acum_anterior
 */
class Amortizacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.amortizacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [['id'], 'required'],
            [['amortizacion_anual_acumulada', 'valor_residual', 'anio', 'r_431', 'r_432', 'r_433', 'r_434', 'r_435', 'r_436', 'r_437', 'r_438', 'r_439', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'default', 'value' => null],
            [['id', 'anio', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['id', 'cantidad_bienes_amortizados','amortizacion_anual_acumulada', 'valor_residual', 'r_431', 'r_432', 'r_433', 'r_434', 'r_435', 'r_436', 'r_437', 'r_438', 'r_439','r_431_acumulada','r_432_acumulada','r_433_acumulada','r_434_acumulada','r_435_acumulada','r_436_acumulada','r_437_acumulada','r_438_acumulada','r_439_acumulada','precio_origen_total','r_431_valor_residual','r_432_valor_residual','r_433_valor_residual','r_434_valor_residual','r_435_valor_residual','r_436_valor_residual','r_436_valor_residual','r_437_valor_residual','r_438_valor_residual','r_439_valor_residual','r_431_precio_origen','r_432_precio_origen','r_433_precio_origen','r_434_precio_origen','r_435_precio_origen','r_436_precio_origen','r_437_precio_origen','r_438_precio_origen','r_439_precio_origen','r_431_amortizacion_acum_anterior','r_432_amortizacion_acum_anterior','r_433_amortizacion_acum_anterior','r_434_amortizacion_acum_anterior','r_435_amortizacion_acum_anterior','r_436_amortizacion_acum_anterior','r_437_amortizacion_acum_anterior','r_438_amortizacion_acum_anterior','r_439_amortizacion_acum_anterior','amortizacion_acum_anterior'], 'number'],
            [['fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
            [['cantidad_bienes_amortizados'], 'safe'],
           // [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amortizacion_anual' => 'Amortizacion Anual',
            'amortizacion_anual_acumulada' => 'Amortizacion Anual Acumulada',
            'valor_residual' => 'Valor Residual',
            'anio' => 'Anio',
            'r_431' => 'R 431',
            'r_432' => 'R 432',
            'r_433' => 'R 433',
            'r_434' => 'R 434',
            'r_435' => 'R 435',
            'r_436' => 'R 436',
            'r_437' => 'R 437',
            'r_438' => 'R 438',
            'r_439' => 'R 439',
            'r_431_acumulada' => 'R 431_acumulada',
            'r_432_acumulada' => 'R 432_acumulada',
            'r_433_acumulada' => 'R 433_acumulada',
            'r_434_acumulada' => 'R 434_acumulada',
            'r_435_acumulada' => 'R 435_acumulada',
            'r_436_acumulada' => 'R 436_acumulada',
            'r_437_acumulada' => 'R 437_acumulada',
            'r_438_acumulada' => 'R 438_acumulada',
            'r_439_acumulada' => 'R 439_acumulada',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_baja' => 'Fecha Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
        ];
    }
    public function getDatosRubros(){
        return $this->hasOne(PatrimonioRubro::class, ['id'=>'codigo_presupuestario']);
    }
}
