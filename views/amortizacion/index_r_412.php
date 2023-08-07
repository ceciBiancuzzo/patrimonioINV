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
use patrimonio\parametros\PatrimonioRubro;
use patrimonio\models\Amortizacion;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use kartik\tabs\TabsX;


   
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        //'id',
        ['attribute'=>'id_rubro','label'=>'Rubro','value'=>function($modelBienes){
            $modelRubro = PatrimonioRubro::find()->where(['id'=>$modelBienes->id_rubro])
                                                ->all();
            if($modelRubro[0]->codigo_presupuestario==412){
            
            return $modelRubro[0]->codigo_presupuestario;
            }
            else {
                return "+";
            }
            },
        ], 
        ['attribute'=>'nro_inventario','label'=>'Nro de inventario','value'=>function($modelBienes){
            return $modelBienes->nro_inventario?$modelBienes->nro_inventario:0;
            },
        ],    

        ['attribute'=>'id','label'=>' Descripcion Bien',
        'value'=>function($modelBienes){
         $bien = BienUso::find()->where(['id'=>$modelBienes->id])->all();  
       
         if ($bien[0]->id) {
            return $bien[0]->tipo_bien.' / '.$bien[0]->modelo; 
            //return $bien[0]->tipo_bien.' / '.$bien[0]->modelo.' / '.$bien[0]->nro_inventario;
         }else {
             return 0;
         }
         
           
          
            
         
           },
       ],

       ['attribute'=>'anio_alta','label'=>'Año Alta',
       'value'=>function($modelBienes){
           if($modelBienes->anio_alta){
             return $modelBienes->anio_alta;
           }else{
             return 0; 
           }
        
        
          },
     ],

     ['attribute'=>'precio_origen','label'=>'Precio Origen','value'=>function($modelBienes){
          
        return $modelBienes->precio_origen?$modelBienes->precio_origen:0;
        },
        'format' => ['decimal', 2],
        'pageSummary' => true
    ],
    ['attribute'=>'valor_rezago','label'=>'Valor Rezago','value'=>function($modelBienes){
        return $modelBienes->valor_rezago?$modelBienes->valor_rezago:0;
        },

        'format' => ['decimal', 0],
        //'pageSummary' => true
    ], 

        
     

             ['attribute'=>'vida_util','label'=>'Vida Util','value'=>function($modelBienes){
            return $modelBienes->vida_util?$modelBienes->vida_util:0;
            },
        ], 

        

        ['attribute'=>'vida_util_transcurrida','label'=>'Vida util Trascurrida','value'=>function($modelBienes){
          
            return $modelBienes->vida_util_transcurrida?$modelBienes->vida_util_transcurrida:0;
            },

         
        ], 

        ['attribute'=>'amortizacion_anual','label'=>'Amortizacion Anual',
        'value'=>function($modelBienes){
            if($modelBienes->amortizacion_anual){
              return $modelBienes->amortizacion_anual;
            }else{
              return 0; 
            }
         
         
          },

          'format' => ['decimal', 2],
          'pageSummary' => true
       ],

       
       ['attribute'=>'amortizacion_anual_acumulada','label'=>'Amortizacion Anual Acumulada',
       'value'=>function($modelBienes){
           if($modelBienes->amortizacion_anual_acumulada){
             return $modelBienes->amortizacion_anual_acumulada;
           }else{
             return 0; 
           }
        
        
         },

         
         'format' => ['decimal', 2],
         'pageSummary' => true
      ],

        ['attribute'=>'valor_residual','label'=>'Valor Residual','value'=>function($modelBienes){
          
            return $modelBienes->valor_residual?$modelBienes->valor_residual:0;
            },

            'format' => ['decimal', 2],
            'pageSummary' => true,
         //   'pageSummaryFunc' => GridView::F_AVG  
        ],

    ];

    ?>
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
            'id'=>'412',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showPageSummary' => true,
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
                    '{toggleData}',
                    '{export}',
                    $todos_registros_ExportMenu
               ],    


               'exportConfig' => [
                GridView::CSV => [
                    'label' => 'CSV',
                    'filename' => 'Amortizacion'." - "."412",
                    'options' => ['title' => 'Amortizacion'." - "."412"],
                ],
                GridView::EXCEL => [
                    'label' => 'Excel',
                    'filename' => 'Amortizacion'." - "."412",
                    'options' => ['title' => 'Amortizacion'." - "."412"],
                ],
                GridView::PDF => [
                    'label' => 'PDF',
                    'filename' => 'Amortizacion'." - "."412",
                    'options' => ['title' => 'Amortizacion'." - "."412"],
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