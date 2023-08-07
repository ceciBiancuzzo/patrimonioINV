<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use kartik\datecontrol\DateControl;
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 
if (strpos($perfil, 'Administrador')== 1){
    $disabled = false;
}else{
    $disabled = true;
}

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AmortizacionAnualCab */
/* @var $form yii\widgets\ActiveForm */
$delegaciones = parametros\models\ParametrosDelegaciones::find()->all();
$personas = gestion_personal\models\PersonalAgente::find()->where(['estado' => 'A'])->all();
?>

<div class="amortizacion-anual-cab-form">

    <?php $form = ActiveForm::begin(['id' => 'registro_amortizacion']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
           Comisión
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
            <div
         </div>   
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                   
                       
                        
                        'denominacion'=> [
                            'label' => 'Denominacion ',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese Nueva Comisión',
                            ]
                        ],

                        'anio'=> [
                            'label' => 'Año',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese Año',
                            ]
                        ],

                   
                    ]
                ]);
                ?> 

                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                      
                        'id_delegacion'=> [
                            'label' => 'Delegación',
                            'id' => 'id_delegacion',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => yii\helpers\ArrayHelper::map($delegaciones, 'id', 'descripcion_delegacion'), 'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione  Rubro',]
                            ] 
                        ], 
                        'activa' => [
                            'label' => 'Activa',
                            'type' => Form::INPUT_RADIO_LIST,
                            'items' => [true => 'Si', false => 'No'],
                            'options' => ['inline' => true, 'default' => 'No']
                        ],
                        
                    

                    ]
                ]);
                ?> 
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                      
                   
                    

                        'persona1'=> [
                            'label' => 'Participante 1',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'id' => 'id_delegacion',
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                        'persona2'=> [
                            'label' => 'Participante 2',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'id' => 'id_delegacion',
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                    ]
                ]);
                ?> 
                 <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                
                        
                    

                        'persona3'=> [
                            'label' => 'Participante 3',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                           
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                        'persona4'=> [
                            'label' => 'Participante 4',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                          
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                    ]
                ]);
                ?> 
                 <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                      
                 
                        
                    

                        'persona5'=> [
                            'label' => 'Participante 5',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                           
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                        'persona6'=> [
                            'label' => 'Participante 6',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                          
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($personas, 'id', 'strAgente'),
                                'options' => [
                                    'placeholder' => 'Seleccione Persona',
                                ]
                            ]
                        ],
                    ]
                ]);
                ?> 
 

    <div class="form-group">
    <?php
        if (strpos($perfil, 'Administrador')== 1){?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
