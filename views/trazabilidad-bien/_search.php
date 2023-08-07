<?php
use yii\helpers\Url;
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

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$estadosFormulario = patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$tiposMovimientos = patrimonio\parametros\PatrimonioTipoMovimiento::find()->all();
// $depositos = patrimonio\parametros\PatrimonioDeposito::find()->all();
$bienes= patrimonio\models\BienUso::find()->all();
$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
$seccion = patrimonio\parametros\PatrimonioDependencia::find()->all();

// $valor=false;

// if($valor){
//     $accion= ['print'];  //accion update
// }else{
//     $accion = ['index'];
// }

?>

<div class="evento-search">

    <?php
    $form = ActiveForm::begin([
                'action' =>  '',
                'method' => 'get',
                'id' => 'formprincipal'
    ]);
    ?>
    
    
   <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_bien_uso' => [
                'label' => 'Numero de inventario',
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder'=>'Indique el numero de inventario',]
                
            ],
            'id_condicion' => [
                'label' => 'Condición',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($condicionBien, 'id', 'descripcion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => [
                        'placeholder' => 'Condición del bien',
                    //'options' => $productosvarietales,
                    ]
                ],
            ],
            'id_estado' => [
                'label' => 'Estado interno',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadosFormulario, 'id', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => [
                        'placeholder' => 'Estado interno',
                    //'options' => $productosvarietales,
                    ]
                ],
            ],
            
       ]
   ]);
   ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_usuario_actual' => ['label' => 'Usuario actual', 'type' => Form::INPUT_WIDGET, 
            'widgetClass' => '\kartik\widgets\Select2',
            'options' => [
                'data'=>yii\helpers\ArrayHelper::map($usuario,'id','strAgente'),'pluginOptions' => ['allowClear' => true],
                'options' => [
                    'placeholder' => 'Usuario actual',
                //'options' => $productosvarietales,
                ]
            ]],
            // 'id_usuario_anterior' => ['label' => 'Usuario anterior', 'type' => Form::INPUT_WIDGET, 
            // 'widgetClass' => '\kartik\widgets\Select2',
            // 'options' => [
            //     'data'=>yii\helpers\ArrayHelper::map($usuario,'id','strAgente'),'pluginOptions' => ['allowClear' => true],
            //     'options' => [
            //         'placeholder' => 'Usuario anterior',
            //     //'options' => $productosvarietales,
            //     ]
            // ]],
            'id_area_actual' => ['label' => 'Area actual', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($seccion,'id','denominacion'),'pluginOptions' => ['allowClear' => true],
                                   'options' => [
                                    'placeholder' => 'Area actual',
                                //'options' => $productosvarietales,
                                ]
                                ]],
            'id_area_anterior' => ['label' => 'Area anterior', 'type' => Form::INPUT_WIDGET, 
            'widgetClass' => '\kartik\widgets\Select2',
            'options' => [
                    'data'=>yii\helpers\ArrayHelper::map($seccion,'id','denominacion'),'pluginOptions' => ['allowClear' => true],
                    'options' => [
                    'placeholder' => 'Area actual',
                    //'options' => $productosvarietales,
                    ]
                    ]],
            
       ]
   ]);
   ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'rangoFecha' => [
                'label' => 'Rango fecha carga',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => kartik\daterange\DateRangePicker::classname(),
                'useWithAddon' => false,
                'convertFormat' => true,
                'clearBtn'=>true,

                'options' => ['pluginOptions' =>
                        [
                        'locale' => [
                            'format' => 'DD/MM/YYYY',
                            'separator' => ' a '
                        ]
                        
                    ]
                    
                ]
            ],
    
            'tipo_movimiento' => [
                'label' => 'Tipo de movimiento',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($tiposMovimientos, 'denominacion', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => [
                        'placeholder' => 'Tipo de movimiento',
                    //'options' => $productosvarietales,
                    ]
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
        
      <?=Html::Button('<span class="glyphicon glyphicon-print"></span> Imprimir', ['id'=>'btPrint','class' => 'btn btn-success', 'formaction'=>'print'])?>     
       <?= Html::Button('<span class="glyphicon glyphicon-search"></span> Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary','formaction'=>'index']) ?>
        </div>   
        <!-- echo  '   ' . Html::a('Imprimir',['print','id'=>$model->id],['target'=>'_blank','id' => 'btPrint','class' => 'btn btn-warning']) ;  -->
        
            <?php
            
            /* echo Html::a(
                    '<span class="glyphicon glyphicon-question-sign"></span>', '@web/pdf/MovimientoInterno_gestion.pdf', [
                'class' => 'btn btn-primary',
                'title' => '¿Necesitas ayuda?',
                'target' => '_blank',
                'data-toggle' => 'tooltip'
                    ]
            ); */
            ?>
     
     
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$urlPrint= 'trazabilidad-bien/print';
$urlConsultar = 'trazabilidad-bien/index';

$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    $("#btPrint").click(function(){
        //alert("Hola")
        $('[name="r"]').val("$urlPrint");
            $('#formprincipal').attr('target', '_blank').submit();    
    });

    $('#btnConsultar').click(function(){
        //alert("chau")
        $('[name="r"]').val("$urlConsultar");
        $('#formprincipal').attr('target', '').submit();    
    });
JS;

$this->registerJs($script);
?>

