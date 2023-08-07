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

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AmortizacionAnualCab */
/* @var $form yii\widgets\ActiveForm */
$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
$seccion = gestion_personal\models\PersonalOrganigrama::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
?>

<div class="amortizacion-anual-cab-form">
<!-- ?= $form->field($model, 'id')->hiddenInput()->label(false); ?> -->
    <?php $form = ActiveForm::begin(['id' => 'registro_amortizacion']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
Estado
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
                            'label' => 'Denominacion',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Denominación',
                            ]
                        ],
                        'id_organigrama' => ['label' => 'Área organigrama', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($seccion,'id','desc_desempenio'),
                                   'options' => ['placeholder'=>'Seleccione el area'], 
                                ],
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
                       
                        'codigo_dependencia'=> [
                            'label' => 'Código dependencia',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Código dependencia',
                            ]
                            ],
                            'id_jefe' => ['label' => 'Jefe del area', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($usuario,'id','strAgente'),
                                    'disabled' => false, 
                                    'options' => ['placeholder'=>'-'], 
                                    ]],    
                ]
                ]);
                ?> 

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
