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
use kartik\widgets\Spinner;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AmortizacionAnualCab */
/* @var $form yii\widgets\ActiveForm */
$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
?>

<div class="amortizacion-anual-cab-form">

    <?php $form = ActiveForm::begin(['id' => 'registro_amortizacion']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            Amortización
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
                    'columns' => 3,
                    'attributes' => [
                        /* 'id_seccion'=> [
                            'label' => 'Rubro',
                            'id' => 'id_seccion',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => yii\helpers\ArrayHelper::map($rubro, 'id', 'strRubro'), 'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione  Rubro',]
                            ] 
                        ], */
                        
                        'anio' => [
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => 'kartik\widgets\DatePicker',
                                'useWithClass' => true,
                                'convertFormat' => true,
                                'label' => 'Año amortizacion',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy',
                                        'allowClear' => false,
                                        'todayHighlight' => true,
                                        'startView' => 'year',
                                        'minViewMode' => 'years',
                                        'startDate' => "2019",
                                    ],
                                ],
                            ],
                    ]
                ]);
                ?> 
 

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Generar Amortización', ['id'=> 'btnGuardar','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $('form').submit(function() {

        $("#btnGuardar").prop('disabled',true);     
    });

       
JS;
$this->registerJs($script);
?>