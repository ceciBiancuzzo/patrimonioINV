<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\bs5dropdown\ButtonDropdown;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\ActaRecepcionDetalle*/
/* @var $form yii\widgets\ActiveForm */

$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$condicion = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
//$formaAdquisicion = patrimonio\models\ActaRecepcionCabecera::find()->all();
?>


<div class="well" align='center'>
    <div class='panel panel-primary'>
        <h4>Nueva Acta de Recepcion </h4>
    </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            DATOS
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <?=
                    Form::widget([
                        'model'=> $model,
                        'form'=> $form,
                        'columns'=> 3,                            
                        'attributes' => [
                                    'id_delegacion'=> [
                                        'label' => 'Delegacion',
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\widgets\Select2',
                                        'id' => 'id_delegacion',
                                        'options' => [
                                            'data'=>yii\helpers\ArrayHelper::map($delegaciones, 'id', 'descripcion_delegacion'),
                                            'options' => [
                                                'placeholder' => 'Seleccione Delegacion',
                                            ]
                                        ]
                                    ],
                                    'fecha_acta' => [
                                        'label' => 'Fecha de Acta',
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => kartik\date\DatePicker::classname(),
                                        'useWithAddon' => true,
                                        'convertFormat' => true,
                                        'options' => ['pluginOptions' => [
                                                'locale' => [
                                                    'format' => 'DD/MM/YYYY',
                                                ]
                                            ]]
                                    ],
                                    'nro_acta'=> [
                                        'label' => 'Numero de Acta',
                                        'type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'placeholder' => 'Ingrese numero de acta',
                                        ]
                                    ],
                                    'orden_compra'=> [
                                        'label' => 'Orden de compra',
                                        'type' => FORM::INPUT_TEXT,
                                        'options' => [
                                            'placeholder' => 'Ingrese orden de compra',
                                        ]
                                    ],
                                    'nro_expediente'=> [
                                        'label' => 'Numero de Expediente',
                                        'type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'placeholder'=> 'Ingrese numero de expediente',
                                        ]
                                    ],
                                    'forma_adquisicion' => [
                                        'label' => 'Forma de Adquisicion',
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\widgets\Select2',
                                        'options' => [
                                            //'data'=>yii\helpers\ArrayHelper::map($formaAdquisicion, 'id', 'forma_adquisicion'),
                                            'options' => [
                                                'placeholder' => 'Seleccione Forma de Adquisicion',
                                            ]
                                        ]
                                    ],
                                    'id_condicion' => [
                                        'label' => 'Condicion del Bien',
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\widgets\Select2',
                                        'options' => [
                                            'data'=>yii\helpers\ArrayHelper::map($condicion, 'id', 'descripcion'),
                                            'options' => [
                                                'placeholder' => 'Seleccione Condicion',
                                            ]
                                        ]
                                    ],
                                ], 
                    ])
                ?> 
            </div>
        </div>
        
        <div class="form-group">
            <?php 
            $urlRegresar = "acta-recepcion-cabecera/index";
            echo Html::a('Regresar', [$urlRegresar],['id'=> 'btRegresar', 'class'=> 'btn btn-info']);
            ?>
            <?= Html::submitButton('Crear Acta', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>


    <?php ActiveForm::end(); ?>

</div>
