<?php
//use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;


$marcas= patrimonio\parametros\PatrimonioMarca::find() ->orderBy(['id' => SORT_DESC])->all();
//$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
$estados= patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$condiciones = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$area= patrimonio\parametros\PatrimonioArea::find()->all();


/* @var $this yii\web\View */
/* @var $model administracion_general\models\Aplicacion */

?>

<?php 

$attributes = [
    [
        'group'=>true,
        'label'=>'SECCION 1: DATOS GENERALES DE TRANSFERENCIA',
        'rowOptions'=>['class'=>'table-info']
    ],
    
    [
        'columns' => [
            [
                'attribute'=>'id_dependencia', 
                'label'=>'Area que transfirió',
                'value'=>isset($model->id_dependencia)? $model->areaRecepciona->denominacion:'-' ,
                'displayOnly'=>true,
                //'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'attribute'=>'id_dependencia2', 
                'label'=>'Area que recepcionó',
                'value'=>isset($model->id_dependencia2)? $model->areaTransferencia->denominacion:'-' ,
                'displayOnly'=>true,
                //'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'nro_acta_transferencia', 
                'label'=>'Numero de acta',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],

        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'fecha_transferencia', 
                'label'=>'Fecha de transferencia',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'fecha_recepcion', 
                'label'=>'Fecha de Recepcion',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
        ],

    ],
    [
        'columns' => [
            [
                'attribute'=>'id_usuario_transferencia', 
                'label'=>'Usuario que transfirió',
                'value'=>isset($model->id_usuario_transferencia)? $model->usuarioTransferencia->strAgente:'-' ,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'id_usuario_recepcion', 
                'label'=>'Usuario receptor',
                'value'=>isset($model->id_usuario_recepcion)? $model->usuarioRecepciona->strAgente:'-' ,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
        ],

    ],
    [
        'group'=>true,
        'label'=>'SECCION 2: DETALLE DE TRANSFERENCIA',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'observaciones', 
                'label'=>'Observaciones',
                'displayOnly'=>true,
                'value'=>isset($model->observaciones_aprobado)? $model->observaciones_aprobado:'-' ,
                'valueColOptions'=>['style'=>'width:100%']
            ],
        ],
    ],        
];
?>

    <?php
// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'hAlign'=>'right',
    // 'vAlign'=>'middle',
   // 'fadeDelay'=>$fadeDelay,
    'panel' => [
        'type' => 'info', 
        'heading' =>'<div class="">DATOS DE TRANSFERENCIA</div>',
        'footer' => '<div class="text-center">Datos de la última transferencia del bien.</div>'
    ],
    
    //s'container' => ['id'=>'kv-demo'],
    //'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);

 
?>
    
   
<?php
$id_agente = $model->id;
// javascript for triggering the dialogs
$js = <<< JS

JS;

// register your javascript
$this->registerJs($js);
?>

