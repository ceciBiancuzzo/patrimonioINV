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
$seccion =patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
?>

<div class="amortizacion-anual-cab-form">
<!-- ?= $form->field($model, 'id')->hiddenInput()->label(false); ?> -->
    <?php $form = ActiveForm::begin(['id' => 'registro_amortizacion']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
Usuarios externos
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
            <div
           
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                    
                        'nombre_usuario'=> [
                            'label' => 'Usuario',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese nombre y apellido del usuario',
                            ]
                        ],
                        'id_dependencia'=> [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                               'data'=>yii\helpers\ArrayHelper::map($seccion,'id','strDependencia'),'pluginOptions' => ['allowClear' => true],
                               'options' => [
                                'placeholder' => 'En caso de pertenecer a un área indíquela',
                            ]
                        ]
                       
                          
                    ],
                    'dni'=> [
                     'label' => 'DNI',
                     'type' => Form::INPUT_TEXT,
                     'options' => [
                         'placeholder' => 'Ingrese el documento',
                     ]
                 ],
                 'telefono'=> [
                     'label' => 'Telefono',
                     'type' => Form::INPUT_TEXT,
                     'options' => [
                         'placeholder' => 'Ingrese el telefono',
                     ]
                 ],
                ]]);
                ?> 
 

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
