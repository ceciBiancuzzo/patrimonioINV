<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use parametros\models\ParametrosDelegaciones;
use patrimonio\models\PatrimonioEstadoInterno;
use patrimonio\parametros\PatrimonioDependencia;
/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */
$dependencias = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
$estadosFormulario = patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$tiposMovimientos = common\models\parametros\ParametrosTipoMovimientos::find()->all();
// $depositos = patrimonio\parametros\PatrimonioDeposito::find()->all();
$bienes= patrimonio\models\BienUso::find()->where(['fecha_baja' => null])->all();
$rubro = patrimonio\parametros\PatrimonioRubro::find()->where(['fecha_baja' => null])->all();
$marcas = patrimonio\parametros\PatrimonioMarca::find()->where(['fecha_baja' => null])->all();

$anios = [];
for ($i = 1950; $i <= date('Y'); $i++) {
    $anios[$i] = ['id' => $i, 'ano' => $i];
}
?>

<div class="evento-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'id' => 'formprincipal'
    ]);
    ?>

    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [

           
            'nro_inventario' => [
                'label' => 'Numero de inventario',
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder'=>'Indique el numero de inventario',]
                
            ],
            'nro_serie' => ['label' => 'Número de serie', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Indique el número de serie']],

            'descripcion_bien' => [
                'label' => 'Descripción del bien',
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder'=>'Indique la descripción del bien',]
                
            ],
            'tipo_bien' => [
                'label' => 'Tipo de bien',
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder'=>'Indique el tipo de bien',]
                
            ],
        ]
    ]);
    ?> 
   <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 5,
        'attributes' => [
            'id_estado_interno' => [
                'label' => 'Estado interno',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'idestado',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadosFormulario, 'id', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione un Estado',]
                ],
            ],
            'id_rubro' => [
                'label' => 'Rubro',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'idrubro',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($rubro, 'id', 'strRubro'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione un rubro',]
                ],
            ],
            'id_dependencia' => ['label' => 'Dependencia', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($dependencias,'id','strDependencia'),
                                   'options' => ['placeholder'=>'Seleccione la dependencia'], 
                                   'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
            
            'anio_alta' => ['label' => 'Año de alta', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($anios,'ano','ano'),
                                   'options' => ['placeholder'=>'Seleccione el año de alta'], 
                                   'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
                        
         'id_marca' => ['label' => 'Marca', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($marcas,'id','denominacion'),
                                   'options' => ['placeholder'=>'Seleccione la marca'], 
                                   'pluginOptions' => ['allowClear' => true],
                                ],
                            ],
       ]
   ]);
   ?>
   
    <?php
    if (AccessHelpers::getAcceso('delegaciones', Yii::$app->controller->id)) {
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'id_delegacion' => [
                    'label' => 'Delegación',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map(ParametrosDelegaciones::find()->where(['aud_fecbaja' => null])->andWhere(['NOT IN', 'codigo_delegacion', [93, 0, 999, 50, 233]])->all(), 'id', 'descripcion_delegacion'), 'pluginOptions' => ['allowClear' => true],
                        'options' => [
                            'placeholder' => 'Seleccione una Delegación',
                        ]
                    ]
                ]
            ]
        ]);
    }
    ?>
    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-10"><span><?= Html::Button('<span class="glyphicon glyphicon-search"></span> Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
        <div class="col-sm-1">
            <?php
            echo Html::a(
                    '<span class="glyphicon glyphicon-question-sign"></span>', '@web/pdf/Manual-de-Usuario-Sistema-Patrimonio.pdf', [
                'class' => 'btn btn-primary',
                'title' => '¿Necesitas ayuda?',
                'target' => '_blank',
                'data-toggle' => 'tooltip'
                    ]
            );
            ?>
        </div>
        <br>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('#btnConsultar').click(function(){

                $('#formprincipal').submit();
        
    });
JS;

$this->registerJs($script);
?>

