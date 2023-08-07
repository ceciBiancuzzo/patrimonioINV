<?php

namespace patrimonio\models;
use gestion_personal\models\PersonalAgente;

use Yii;

/**
 * This is the model class for table "patrimonio.comision".
 *
 * @property int $id
 * @property string $denominacion
 * @property int $anio
 * @property int $persona1
 * @property int $persona2
 * @property int $persona3
 * @property int $persona4
 * @property int $persona5
 * @property int $persona6
 * @property bool $activa
 * @property string $fecha_carga
 * @property string $fecha_modificacion
 * @property string $fecha_baja
 * @property int $id_usuario_carga
 * @property int $id_usuario_modificacion
 * @property int $id_usuario_baja
 * @property int $id_delegacion

 */
class PatrimonioComision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrimonio.comision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denominacion'], 'string'],
            [['anio', 'persona1', 'persona2', 'persona3', 'persona4',  'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'default', 'value' => null],
            [['anio', 'persona1', 'persona2', 'persona3', 'persona4', 'persona5', 'persona6','id_delegacion', 'id_usuario_carga', 'id_usuario_modificacion', 'id_usuario_baja'], 'integer'],
            [['persona1', 'persona2'], 'required'],
            [['activa'], 'boolean'],
            [['fecha_carga', 'fecha_modificacion', 'fecha_baja'], 'safe'],
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
            'anio' => 'Anio',
            'persona1' => 'Persona1',
            'persona2' => 'Persona2',
            'persona3' => 'Persona3',
            'persona4' => 'Persona4',
            'persona5' => 'Persona5',
            'persona6' => 'Persona6',
            'activa' => 'Activa',
            'fecha_carga' => 'Fecha Carga',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha_baja' => 'Fecha Baja',
            'id_usuario_carga' => 'Id Usuario Carga',
            'id_usuario_modificacion' => 'Id Usuario Modificacion',
            'id_usuario_baja' => 'Id Usuario Baja',
        ];
    }
    public function getStrComision(){
        if($this->persona3 == null && $this->persona4 == null && $this->persona5 == null && $this->persona6 == null){
            return strtoupper($this->denominacion).' ( '.strtolower($this->persona_1->strAgente).' - '.strtolower($this->persona_2->strAgente).' - '.' ) ';
            }
        if($this->persona4 == null && $this->persona5 == null && $this->persona6 == null){
            return strtoupper($this->denominacion).' ( '.strtolower($this->persona_1->strAgente).' - '.strtolower($this->persona_2->strAgente).' - '.
            strtolower($this->persona_3->strAgente).' ) ';
        }
        if($this->persona5 == null && $this->persona6 == null){
        return strtoupper($this->denominacion).' ( '.strtolower($this->persona_1->strAgente).' - '.strtolower($this->persona_2->strAgente).' - '.
        strtolower($this->persona_3->strAgente).' - '.strtolower($this->persona_4->strAgente).' ) ';
        }
        if($this->persona6 == null){
            return strtoupper($this->denominacion).' ( '.strtolower($this->persona_1->strAgente).' - '.strtolower($this->persona_2->strAgente).' - '.
            strtolower($this->persona_3->strAgente).' - '.strtolower($this->persona_4->strAgente).' - '.strtolower($this->persona_5->strAgente).' ) ';
        }
        if($this->persona5 != null && $this->persona6 != null){
            return strtoupper($this->denominacion).' ( '.strtolower($this->persona_1->strAgente).' - '.strtolower($this->persona_2->strAgente).' - '.
            strtolower($this->persona_3->strAgente).' - '.strtolower($this->persona_4->strAgente).' - '.strtolower($this->persona_5->strAgente).' - '.strtolower($this->persona_6->strAgente).' ) ';
        }

    }
    
    public function getPersona_1(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona1']);
    }

    public function getPersona_2(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona2']);

    }
    public function getPersona_3(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona3']);
        
    }
    public function getPersona_4(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona4']);
        
    }
    public function getPersona_5(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona5']);
        
    }
    public function getPersona_6(){
        return $this->hasOne(PersonalAgente::class, ['id'=>'persona6']);
        
    }

}