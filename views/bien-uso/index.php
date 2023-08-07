<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use patrimonio\parametros\PatrimonioPartida;
use patrimonio\parametros\PatrimonioRubro;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\parametros\PatrimonioDependencia;
//print_r($dataProvider);die();
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InicEspumosoCabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Modal::begin([
    'header' => '<h2>Cargar numero de serie</h2>',
    'headerOptions' => ['id' => 'modalTransferenciaHeader'],
    'id' => 'modalTransferencia',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentTransf'>Cargando... Espere...</div>";
Modal::end();     

Modal::begin([
    'header' => '<h2>Carga de número de serie</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    /*'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],*/
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentFile'></div>";
Modal::end();

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
    ]);
$titulo = 'Bienes';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="inic-espumoso-cab-index" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Consulta de <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>
    <div class="well" align="right">
    <span><?= Html::Button('<span class="glyphicon glyphicon-export"></span> Exportar', ['id'=>'btnExportar','class' => 'btn btn-success']) ?></span>
 
    </div>

    <?php
            
    $gridColumns = [
            
            ['attribute'=>'nro_inventario','label'=>'Número de inventario','value'=>function($model){
                return $model->nro_inventario?$model->nro_inventario:"   - ";
                },    'hAlign' => 'center',

            ],    
            ['attribute'=>'id_rubro','label'=>'Rubro','value'=>function($model){
                if($model->rubro){
               return $model->rubro->strRubro;
               }else{
                   return "-";
               }
           },    'hAlign' => 'center',

            ], 
            ['attribute'=>'id_condicion','label'=>'Condición del bien','value'=>function($model){
                if($model->condicion){
               return $model->condicion->descripcion;
               }else{
                   return "-";
               }
           },    'hAlign' => 'center',

            ], 
            ['attribute'=>'tipo_bien','label'=>'Tipo de bien','value'=>function($model){
                return $model->tipo_bien?$model->tipo_bien:" - ";
                },    'hAlign' => 'center',

            ],        
            [
                'attribute'=>'id_marca',
                'label'=>'Marca',
                'value'=>function($model){
                    if($model->marcas){
                return $model->marcas->denominacion;
                }else{
                    return "-";
                }
            },'hAlign' => 'center',
            ],
            ['attribute'=>'modelo','label'=>'Modelo','value'=>function($model){
                return $model->modelo?$model->modelo:" - ";
                },    'hAlign' => 'center',

            ],       
            ['attribute'=>'fecha_carga','label'=>'Fecha de origen',
                    'format'=>['date','php:d/m/Y'],

                    'value'=>function($model){
                        return $model?$model->fecha_carga:"-";
                        
                   },    'hAlign' => 'center',
            ],
             ['attribute'=>'nro_serie',
             'label' => 'Número de serie',
             'value'=>function($model){
                return $model->nro_serie?$model->nro_serie:'-';
            }, 'hAlign' => 'center',
           ],
           ['attribute'=>'id','label'=>'Dependencia','value'=>function($model){
            if ($model->dependencia) {
                return $model->dependencia->strDependencia;
            }else {
                return "-";
            }
            }, 'hAlign' => 'center',
        ],  
                ['attribute'=>'id_estado_interno','label'=>'Estado interno','value'=>function($model){
                    if($model->estadoInterno){
                return $model->estadoInterno->denominacion;
                }else{
                    return "-";
                }
            }, 'hAlign' => 'center',
        ],
        ['class' => 'kartik\grid\ActionColumn',
        'template' => ' {update}{print}{delete}',
            'buttons' => [
            'update' => function ($url,$searchModel) {
                //print_r($searchModel);die();
                return "   ".Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    ['update', 'id'=>$searchModel['id']] ,
                    [
                        'title' => 'Imprimir',
                        'data-pjax' => '0',

                        //'target'=>'_blank'
                        
                    ]
                );
            
        },
        'print' => function ($url,$searchModel) {
            return "   ".Html::a(
                '<span class="glyphicon glyphicon-print"></span>',
                ['print', 'id'=>$searchModel['id']] ,
                 
                [
                    'title' => 'Imprimir',
                    'target'=>'_blank'
                ]
            );
        }, 
            'delete' => function ($url,$searchModel) {
                    return "   ".Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        ['delete', 'id'=>$searchModel['id']] , 
                        [
                            'title' => 'Eliminar',
                            'data'=>[
                                'confirm'=>Yii::t('app', '¿Está seguro que desea eliminar esta transferencia?'),
                                'method'=>'post',
                        ], 
                            
                        ]
                    );
                
            },
            
                            
        ], 
                       
    ],            
    ];
    ?>
    <div  class="well">
    <?php
          ///      print_r($dataProvider);die();
          if($dataProvider->getTotalcount() > 10000){
            $todos_registros_ExportMenu = ExportMenu::widget([
              'id'=>'exportExcel',
              'dataProvider' => $dataProvider,
              'columns' => $gridColumns,
              'target' => ExportMenu::TARGET_BLANK,
              'batchSize' => 30000,
              'pjaxContainerId' => 'kv-pjax-container',
              'exportContainer' => [
                  'class' => 'btn-group mr-2'
              ],
              'dropdownOptions' => [
                  'label' => 'Exportar Todo',
                  'class' => 'btn btn-secondary',
                  'itemsBefore' => [
                      '<div class="dropdown-header">Exportar Todo</div>',
                  ],
              ],
              'exportConfig' => [
                      ExportMenu::FORMAT_EXCEL => [
                          'fontAwesome' => true,
                          'label' => 'Excel',
                          'filename' => 'Lista',
                          'options' => ['title' => 'Lista'],                 
                      ],            
                      ExportMenu::FORMAT_TEXT => false,
                      ExportMenu::FORMAT_HTML => false,
                      ExportMenu::FORMAT_EXCEL_X => false,
                      ExportMenu::FORMAT_PDF => false,
                      ExportMenu::FORMAT_CSV => false,            
              ],        
          ]) ;
          }else{
              $todos_registros_ExportMenu='';
          } 
          
       ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            
            'layout' => '{summary}{items}{pager}',
            'pager' => [
                'firstPageLabel' => 'Primera',
                'lastPageLabel' => 'Ultima',
            ],
            'striped' => false,
           'hover' => true,
           'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
            'columns' => $gridColumns,

               'panel' => [
                   'type' => GridView::TYPE_INFO,
               ],  

               'toolbar' =>  [ 
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Resetear Grilla'])
                    ],
                    '{toggleData}',
                    '{export}',
                    $todos_registros_ExportMenu,

                ],    
 
        
                'exportConfig' => [
                 GridView::CSV => [
                     'label' => 'CSV',
                     'filename' => 'Bien de Uso',
                     'options' => ['title' => 'Bien de Uso'],
                 ],
                 GridView::EXCEL => [
                     'label' => 'Excel',
                     'filename' => 'Bien de Uso',
                     'options' => ['title' => 'Bien de Uso'],
                 ],
                 GridView::PDF => [
                     'label' => 'PDF',
                     'filename' => 'Bien de Uso',
                     'options' => ['title' => 'Bien de Uso'],
                 ],
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
                // if ($model->fecha_presentacion == null){
                //     return ['style' => 'visibility:collapse;'];
                // } else {
                //     return ['style' => 'visibility:visible;'];
                // }
                // if ($model->idestado == 0){
                //     return ['style' => 'visibility:collapse;'];
                // } else {
                //     return ['style' => 'visibility:visible;'];
                // }                
            }, 
           ]); 

        ?>
    </div>  
      
</div>
<?php 
//$urlUpdate = \yii\helpers\Url::to(['bien-uso/index-detalle']) ;
$url = Yii::$app->request->baseUrl. '/index.php?r=espumante-movimientos-internos-cab/presentacion-masiva';
$token = Yii::$app->request->getCsrfToken();
$urlExcel1 = 'bien-uso/export-excel-bienes';

$script = <<< JS
    $('#btnExportar').click(function(){
       
            //alert("aqui");
            //return
            $('[name="r"]').val("$urlExcel1");
            $('#formprincipal').attr('target', '_blank').submit();       
          
            //$("#form_exporta").submit();

            // // $("#formprincipal").attr("target","_blank");
            // // $("#formprincipal").attr("action","../../views/genera-existencias/exportarTXT.php").submit();
            // location.reload();
        });
    $("button[name*=\'btEditar\']").click(function(){
    $("#modalTransferenciaHeader").find("h2").html("Ver transferencia");   
    $("#modalTransferencia").modal("show")
        .find("#modalContentTransf")
        .load($(this).attr("value"));
});
    $(function(){
        $('#btImportacion').click(function(){
            $('#modalFile').modal('show')
                .find('#modalContentFile')
                .load($(this).attr('value'));
        });
        
        $('#btPresentacionMasiva').click(function(){
           var keys = $('#gridMovimientosInternos').yiiGridView('getSelectedRows');
           $.ajax({
                url: '$url',
                type: 'post',
                data: {
                          ids: keys, 
                          _csrf : '$token'
                      },
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.status == "SUCCESS")
                        $("#gridMovimientosInternos").yiiGridView("applyFilter");
                    else
                        krajeeDialog.alert(obj.message)
                }
           });
        }); 
      
        
    });
JS;

    $this->registerJs($script);
?>