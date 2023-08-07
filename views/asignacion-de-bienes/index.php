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

$usuario= gestion_personal\models\PersonalAgente::find()->where(['id_seccion'=>$area])->all();
$titulo = 'Asignación de bienes';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traz" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4> <?= $titulo ?></h4>
        </div>    
       <!--  ?php echo $this->render('_search', ['model' => $searchModel]); ?>   -->  
    
       <div class="inic-espumoso-cab-index" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Consulta de <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>


    <?php
       
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
         

           //'id',
           ['attribute'=>'nro_inventario','label'=>'Nro de inventario','value'=>function($model){
            return $model->nro_inventario?$model->nro_inventario:" - ";
            },
        ],    
        ['attribute'=>'tipo_bien','label'=>'Tipo de bien','value'=>function($model){
            return $model->tipo_bien?$model->tipo_bien:" - ";
            },
        ],        
     
        'modelo',
        ['attribute'=>'id_rubro','label'=>'Rubro','value'=>function($model){
            if($model->rubro){
           return $model->rubro->strRubro;
           }else{
               return "-";
           }
       }
        ], 
      
         ['attribute'=>'nro_serie',
         'label' => 'Número de serie',
         'value'=>function($model){
            return $model->nro_serie?$model->nro_serie:'-';
        },
       ],
      
            ['attribute'=>'id_estado_interno','label'=>'Estado interno','value'=>function($model){
                if($model->estadoInterno){
            return $model->estadoInterno->denominacion;
            }else{
                return "-";
            }
        }
    ],
    ['attribute'=>'id_condicion','label'=>'Condición del bien','value'=>function($model){
        if($model->condicion){
       return $model->condicion->descripcion;
       }else{
           return "-";
       }
   }
    ], 
    [
        //'class' => 'kartik\grid\EditableColumn',
        'attribute'=>'id_usuario_bien',
        'label'=>'Usuario Asignado',
        //'vAlign' => 'middle',
        //'width' => '210px',
        'value'=>function($model){
            if($model->usuarioAsignado){
                return $model->usuarioAsignado->strAgente;
              }else if($model->usuario_externo){
                return $model->usuario_externo; 
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
    
         'template' => ' {create}{create-externo}',
         'buttons' => [
             
            'create'=>function($url,$dataProvider){
            return "   ".Html::button('<span class="glyphicon glyphicon-tag"></span>', 
            ['title'=>'cambio usuario','name' => 'btNuevo', 
            'class' => 'btn btn-success',
            'value' => \yii\helpers\Url::to(['asignacion-de-bienes/create','id'=>$dataProvider->id]),
        ]);
            },
            'create_externo'=>function($url,$dataProvider){
                return "   ".Html::button('<span class="glyphicon glyphicon-tag"></span>', 
                ['title'=>'cambio usuario','name' => 'btNuevo', 
                'class' => 'btn btn-success',
                'value' => \yii\helpers\Url::to(['asignacion-de-bienes/create','id'=>$dataProvider->id]),
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
            'pager' => [
                'firstPageLabel' => 'Primera',
                'lastPageLabel' => 'Ultima',
            ],

               'panel' => [
                   'type' => GridView::TYPE_INFO,
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