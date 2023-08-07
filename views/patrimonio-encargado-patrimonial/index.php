<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use patrimonio\models\BienUso;
use kartik\widgets\Select2;
use gestion_personal\models\PersonalAgente;
use yii\helpers\Url;

use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;


/* @var $this yii\web\View */
/* @var $searchModel patrimonio\models\search\AsignacionDeBienesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Asignacion De Bienes';


echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Información',
    ]
    ]);
  
  Modal::begin([
    'header' => '',
    'headerOptions' => ['id' => 'modalDetalleHeader'],
    'id' => 'modalDetalle',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
  ]);
  echo "<div id='modalContentDetalle'>Cargando... Espere...</div>";
  Modal::end();   
$area = Yii::$app->user->identity->personalAgente->id_seccion;

$usuario= gestion_personal\models\PersonalAgente::find()->all();
$titulo = 'Designación de encargado patrimonial';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Consulta de encargado patrimonial</h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>

    <div class="traz" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4> <?= $titulo ?></h4>
        </div>    
       <!--  ?php echo $this->render('_search', ['model' => $searchModel]); ?>   -->  
    
    
    <?php
       
       
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute'=>'codigo_dependencia','label'=>'Codigo','value'=>function($model){
                return $model->codigo_dependencia?$model->codigo_dependencia:" - ";
                },
            ],    

           //'id',
           ['attribute'=>'denominacion','label'=>'Denominación','value'=>function($model){
            return $model->denominacion?$model->denominacion:" - ";
            },
        ],    
      
    [
        //'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'id_encargado',
        'label'=>'Encargado asignado',
        //'vAlign' => 'middle',
        //'width' => '210px',
        'value'=>function($model){
            if($model->encargado){
                return $model->encargado->strAgente;
              }else{
                return "-"; 
              }
        
        },
    ],
[
        'attribute'=>'id_encargado2',
        'label'=>'Encargado Asignado 2',
        //'vAlign' => 'middle',
        //'width' => '210px',
        'value'=>function($model){
            if($model->encargado2){
                return $model->encargado2->strAgente;
              }else{
                return "-"; 
              }

              
        
        },



        /* 'editableOptions' =>  function ($model, $key, $index) {
            $usuario= gestion_personal\models\PersonalAgente::find()->all();
            return [
                
                'header' => 'Name', 
                'size' => 'md',
                'inputType' => \kartik\editable\Editable::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                //$usuario= gestion_personal\models\PersonalAgente::find()->all(),
                    'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',],
                    'pluginOptions' => [
                       'autoclose' => true
                    ]
                     
                ],
                
            ];
        } */
    ],
    ['class' => 'kartik\grid\ActionColumn',
    
         'template' => ' {create}',
         'buttons' => [
             
            'create'=>function($url,$dataProvider){
            return "   ".Html::button('<span class="glyphicon glyphicon-tag"></span>', 
            ['title'=>'cambio usuario','name' => 'btNuevo', 
            'class' => 'btn btn-success',
            'value' => \yii\helpers\Url::to(['patrimonio-encargado-patrimonial/create','id'=>$dataProvider->id]),
        ]);
    }
             /* 'asing' => function ($url,$searchModel) {
                 
                     return "   ".Html::a(
                         '<span class="glyphicon glyphicon-tag"></span>',
                         $url, 
     
                         [
                             'title' => 'Asignar',
                             'data'=>[
                                 'confirm'=>Yii::t('app', '¿Está seguro que desea asignar este bien?'),
                                 'method'=>'post',
                             ],
                             
                         ]
                         
                     );
                 
             }, */
                                 
         ],                  
     ], 
    ];

    ?>
    
    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridMovimientosInternos',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,

               'panel' => [
                   'type' => GridView::TYPE_INFO,
               ],  
               'pager' => [
                'firstPageLabel' => 'Primera',
                'lastPageLabel' => 'Ultima',
            ],
               'toolbar' =>  [ 
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Resetear Grilla'])
                    ],
                    '{toggleData}'
               ],    


               // set a label for default menu
               'export' => [
                   'label' => 'Pagina',
                   'fontAwesome' => true,
               ],    

               'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
               'headerRowOptions'=>['class'=>'kartik-sheet-style'],        

               'pjax'=>false, // pjax is set to always true for this demo
               'persistResize'=>false,
               'responsive'=>true,
               'hover'=>true,  
               'rowOptions' => function($model, $key, $index, $grid){
             
            }, 
           ]); 

        ?>
    </div>  
      
</div>

<?php

//$url = Url::to(['solicitud-cab/create-detalle']);     
//$idsolicitudCab = $model->id?$model->id:"";
//
$token = Yii::$app->request->getCsrfToken();
foreach($dataProvider->models as $id_bien){
    $idCab = $id_bien->id;
    }
//$url = Url::to(['solicitud-cab/datos-usuario']);
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });

    $("button[name*=\'btNuevo\']").click(function(){
        
        $("#modalDetalleHeader").find("h2").html("Nueva Amortización");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value"));
    });
JS;
$this->registerJs($script);
?>