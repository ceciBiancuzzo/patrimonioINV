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
set_time_limit(0);
echo Dialog::widget([
  'libName' => 'krajeeDialogCust', // a custom lib name
  'overrideYiiConfirm' => false,
  'options' => [
      'title' => 'Información',
  ]
  ]);

Modal::begin([
  'header' => 'Nota: Si deja el campo en blanco realizara la Amortizacion de año actual',
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
$titulo = 'Amortizacion';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traz" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4> <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>
    <div class="well" align="right">
    <span><?= Html::Button('<span class="glyphicon glyphicon-export"></span> Exportar', ['id'=>'btnExportar','class' => 'btn btn-success']) ?></span>
 
    </div>
    <span>
        <div class="form-group" align="right">
     <?php
     echo( Html::button('
     <span class="glyphicon glyphicon-check"></span> Generar Amoritzacion', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['amortizacion/create']), 'class' => 'btn btn-success',]) );
     ?>
   </div> 
</span>
    <?php
         
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
         

           //'id',

           ['attribute'=>'anio','label'=>'Año Amortizado',
           'value'=>function($model){
               if($model->anio){
                 return $model->anio;
               }else{
                 return "-"; 
               }
            
            
             },
          ],

          ['attribute'=>'amortizacion_anual','label'=>'Amortizacion Anual Total',
           'value'=>function($model){
               if($model->amortizacion_anual){
                 return $model->amortizacion_anual;
               }else{
                 return "-"; 
               }
            
            
             },
          ],

          ['attribute'=>'amortizacion_anual_acumulada','label'=>'Amortizacion Anual Acumulada Total',
          'value'=>function($model){
              if($model->amortizacion_anual_acumulada){
                return $model->amortizacion_anual_acumulada;
              }else{
                return "-"; 
              }
           
           
            },
         ],

         ['attribute'=>'valor_residual','label'=>'Valor Residual Total',
         'value'=>function($model){
             if($model->valor_residual){
               return $model->valor_residual;
             }else{
               return "-"; 
             }
          
          
           },
        ],

        ['attribute'=>'precio_origen_total','label'=>'Precio Origen Total',
        'value'=>function($model){
            if($model->precio_origen_total){
              return $model->precio_origen_total;
            }else{
              return "-"; 
            }
         
         
          },
       ],

       ['attribute'=>'cantidad_bienes_amortizados','label'=>'Cantidad Bienes Amortizados',
       'value'=>function($model){
           if($model->cantidad_bienes_amortizados){
             return $model->cantidad_bienes_amortizados;
           }else{
             return "-"; 
           }
        
        
         },
      ],

         ['class' => 'kartik\grid\ActionColumn',
         'template' => ' {view}{print}{delete}',
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
             'delete' => function ($url,$searchModel) {
                 
                     return "   ".Html::a(
                         '<span class="glyphicon glyphicon-trash"></span>',
                         $url, 
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
$urlExcel = 'amortizacion/export-excel-amortizaciones';

//$url = Url::to(['solicitud-cab/datos-usuario']);
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });

    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nueva Amortización");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value"));
            

    });

    $('#btnExportar').click(function(){
    
    //return
    $('[name="r"]').val("$urlExcel");
    $('#formprincipal').attr('target', '_blank').submit();       

    //$("#form_exporta").submit();

    // // $("#formprincipal").attr("target","_blank");
    // // $("#formprincipal").attr("action","../../views/genera-existencias/exportarTXT.php").submit();
    // location.reload();
});

 
JS;

$this->registerJs($script);
?>

