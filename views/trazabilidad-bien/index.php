<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\models\ActaRecepcionCabecera;
use gestion_personal\models\PersonalAgente;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\parametros\PatrimonioArea;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;




Modal::begin([
    'header' => '<h2>Consulta de bienes</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();

Modal::begin([
    'header' => '<h2>Carga de Archivos</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modalFile',
    'size' => 'modal-md',
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
$titulo = 'Trazabilidad';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inic-espumoso-cab-index"  >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4> <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>
    
    <?php
            
    $gridColumns = [
            
            ['attribute'=>'id_bien_uso','label'=>'Bien de uso','value'=>function($model){
                if($model->bienUso && $model->id_bien_uso !=null){
                   return $model->bienUso->strBien;
                }else{
                   return "-";
                }
             
               },
            ],
            
            ['attribute'=>'id_condicion','label'=>'Condición','value'=>function($model){
                if($model->condicion && $model->id_condicion !=null){
                   return $model->condicion->descripcion;
                }else{
                   return "-";
                }
             
               },
            ], 
            ['attribute'=>'id_estado','label'=>'Estado interno','value'=>function($model){
                if($model->estadoInterno && $model->id_estado !=null){
                   return $model->estadoInterno->denominacion;
                }else{
                   return "-";
                }
             
               },
            ],  
            [
                'attribute'=>'id_estado_formulario',
                'label'=>'Estado Formulario',
                'value'=>function($model){
                    if($model->id_estado_formulario == 1){ 
                        return "Borrador";
                        }else if($model->id_estado_formulario == 2){
                            return "Pendiente";
                                }else if ($model->id_estado_formulario == 3){
                                    return "Aprobado";
                                        }else if ($model->id_estado_formulario == 4){
                                            return "Rechazado";
                                                }else if ($model->id_estado_formulario == 5){
                                                    return "Recibido";
                                                        }else if ($model->id_estado_formulario == null){
                                                            return " - ";
                                                                }    
                                                    }
                
                
                    ],
            ['attribute'=>'id_usuario_actual','label'=>'Usuario asignado',
            'value'=>function($model){
                if($model->usuarioRecepciona && $model->id_usuario_actual !=null){
                  return $model->usuarioRecepciona->strAgente;
                }else{
                  return "-"; 
                }
             
             
              },
           ],
            
         
           ['attribute'=>'str_seccion_actual','label'=>' Area Actual',
           'value'=>function($model){
               if($model->id_area_actual !=null && $model->areaRecepciona){
                  return $model->areaRecepciona->denominacion;
               }else{
                  return "-";
               }
            
              },
          ], 

            ['attribute'=>'str_seccion_anterior','label'=>' Area Anterior',
            'value'=>function($model){
                if($model->id_area_anterior !=null && $model->areaTransferencia){
                    return $model->areaTransferencia->denominacion;
                 }else{
                    return "-";
                 }
               }
           ], 
            // ['attribute'=>'id_area_anterior','label'=>'Area anterior','value'=>function($model){
            //     return $model->id_area_anterior?$model->id_area_anterior:" - "; 
            //     },
            // ],

            ['attribute'=>'id_recepcion','label'=>' Recepcion',
            'value'=>function($model){
                if($model->nroActaRecepcion){
                   return $model->nroActaRecepcion->nro_acta;
                }else{
                   return "-";
                }
             
               },
           ], 
          
           ['attribute'=>'id_transferencia','label'=>'Transferencia',
           'value'=>function($model){
               if($model->nroActaTransferencia !=null){
                  return $model->nroActaTransferencia->nro_acta_transferencia;
               }else{
                  return "-";
               }
            
              },
          ], 
          [
            'attribute'=>'fecha_carga',
            'format'=>['date', 'php:Y/m/d'],
            'label'=>'Fecha'
        ],
          /* ['attribute'=>'id_solicitud','label'=>' Solicitud',
           'value'=>function($model){
               if($model->id_solicitud){
                  return $model->id_solicitud;
               }else{
                  return "-";
               }
            
              },
          ], */ 
          ['attribute'=>'tipo_movimiento','label'=>'Tipo de movimiento',
          'value'=>function($model){
              if($model->tipo_movimiento){
                 return $model->tipo_movimiento;
              }else{
                 return "-";
              }
           
             },
         ], 


 
            
           /*  ['class' => 'kartik\grid\ActionColumn',
            'template' => '{print}',
            'buttons' => [
                'print' => function ($url,$searchModel) {
                    return "   ".Html::a(
                        '<span class="glyphicon glyphicon-print"></span>',
                        $url, 
                        [
                            'title' => 'Imprimir',
                            'target'=>'_blank'
                        ]
                    );
                },                          
            ],                
        ], */   
                 
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
                    '{toggleData}',
                    '{export}'
                ],    
 
 
                'exportConfig' => [
                 GridView::CSV => [
                     'label' => 'CSV',
                     'filename' => 'Trazabilidad',
                     'options' => ['title' => 'Trazabilidad'],
                 ],
                 GridView::EXCEL => [
                     'label' => 'Excel',
                     'filename' => 'Trazabilidad',
                     'options' => ['title' => 'Trazabilidad'],
                 ],
                 GridView::PDF => [
                     'label' => 'PDF',
                     'filename' => 'Trazabilidad',
                     'options' => ['title' => 'Trazabilidad'],
                 ],
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
