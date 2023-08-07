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
use patrimonio\parametros\PatrimonioArea;
use gestion_personal\models\PersonalAgente;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\parametros\PatrimonioEstadosFormularios;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InicEspumosoCabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 

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
$titulo =  'Acta de Transferencia';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

?>

<?php 
if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Jefe')== 1 || strpos($perfil, 'Encargado')== 1 || strpos($perfil, 'Auditor')== 1){
  
        // print_r($dataProvider->models);die();
?>

<div class="inic-espumoso-cab-index" >
    
    <div class="well" align="center">
        <div class="panel panel-primary">
        <h4>Consulta de <?= $titulo ?></h4>
        </div>   
      
        
        <?php echo $this->render('_search', ['model' => $searchModel]); ?> 
    </div>  
        <span>
        <?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1){
            ?>
            <div class="form-group" align="right">
                <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar', ['id'=>'btAutorizacion','class' => 'btn btn-success']) ?>
            </div>
            <?php } ?>
        </span>  
            <?php
//28/03/2022

    // print_r($dataProvider->models);die();

     $opcion_update =  function ($url,$model) {
    if($model->id_estado_formulario >=2 ){
        return "   ".Html::a(
            '   <span class="glyphicon glyphicon-eye-open"></span>',
            $url, 
            [
                'title' => 'Ver'
            ]
        );
    } 
    if($model->id_estado_formulario ==1 ) {
        return "   ".Html::a(
            '  <span class="glyphicon glyphicon-pencil"> </span>',
            $url, 
            [
                'title' => 'Editar'
            ]
        );  
    }                    
};
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute'=>'nro_acta_transferencia','label'=>'Acta',
             'value'=>function($model){
                 if($model->nro_acta_transferencia){
                    return $model->nro_acta_transferencia;
                 }else{
                    return "-"; 
                 }
              
                },
            ],           
            // ['attribute'=>'id_usuario_transferencia','label'=>'Usuario Transfiere',
            //   'value'=>function($model){
            //       if($model->usuarioTransferencia){
            //         return $model->usuarioTransferencia->strAgente;
            //       }else{
            //         return "-"; 
            //       }            
            //     },
            //  ], 
            ['attribute'=>'id_dependencia','label'=>'Seccion que Transfiere',
            'value'=>function($model){
                if($model->areaTransferencia){
                   return $model->areaTransferencia->denominacion;
                }else{
                   return "-"; 
                }
               
               },
           ],  

        //     ['attribute'=>'id_usuario_recepcion','label'=>'Usuario Recepciona',
        //     'value'=>function($model){
        //         if($model->usuarioRecepciona){
        //           return $model->usuarioRecepciona->strAgente;
        //         }else{
        //           return "-"; 
        //         }
        //       },
        //    ], 
            // [
            //     'attribute'=>'str_seccion2',
            //     'label'=>'Sección Recepciona',
                
            // ],

            ['attribute'=>'id_dependencia2','label'=>'Seccion que recepciona',
            'value'=>function($model){
                if($model->areaRecepciona){
                   return $model->areaRecepciona->denominacion;
                }else{
                   return "-"; 
                }
               
               },
           ],  

            ['attribute'=>'fecha_transferencia','label'=>'Fecha inicio',
             'value'=>function($model){
                 if($model->fecha_transferencia){
                    return $model->fecha_transferencia;
                 }else{
                    return "-"; 
                 }
                },

            ],  
            ['attribute'=>'Lapso',
            'value'=>function($model){
               if($model->id_estado_formulario != 3 && $model->id_estado_formulario != 4){
                    return $model->getCantidadDias(); 
                }else{
                    return "-";
                }
                
               },

           ],  
            ['attribute'=>'tipo_solicitud','label'=>'Tipo de Solicitud',
            'value'=>function($model){
                if($model->tipo_solicitud==2){
                   return "Transferencia de bienes";
                }else if($model->tipo_solicitud==3){
                   return "Transferencia para baja"; 
                }elseif ($model->tipo_solicitud==4) {
                    return "Transferencia para reparaciones";
                }
             
               },
           ], 

// ['class' => '\kartik\grid\CheckboxColumn',
// //el check solo esta disponible para las ddjj en estado borrador
// 'header' => 'Presentar',
// 'checkboxOptions' => function ($model, $key, $index, $column) {
//     if ($model->id_estado_formulario == 1 && $model->detalles != null){
//             return ['disabled' => false];
//         } else{
//             return ['disabled' => true];

//         }
// }
// ],
['attribute'=>'id_estado_formulario',
'label'=>'Estado',
'value'=>function($model){

   if($model->id_estado_formulario == 1){
     return "Borrador";
    }else if($model->id_estado_formulario == 2){
      return "Pendiente";
    }else if($model->id_estado_formulario == 3){
        return "Aprobado";
    }else if ($model->id_estado_formulario == 4){
        return "Rechazado";
    }else if ($model->id_estado_formulario == 5){
    return "Recibido";
}
}
],    
['attribute'=>'id_usuario_recepcion','label'=>'Usuario aprobación',
'value'=>function($model){
    if($model->usuarioRecepciona){
       return $model->usuarioRecepciona->strAgente;
    }else{
       return "-"; 
    }
   
   },
],  

           

            ['class' => 'kartik\grid\ActionColumn',
            'template' => ' {update}{print}{delete}',
            
            'buttons' => [
                'update'=>$opcion_update,
                // 'recepcionar'=>$opcion_recepcion,
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
            'id'=>'gridAutorizacion',
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

               'exportConfig' => [

                       GridView::CSV => [
                           'label' => 'CSV',
                           'filename' => 'INIC',
                           'options' => ['title' => 'Lista de INIC'],
                       ],
                       GridView::EXCEL => [
                           'label' => 'Excel',
                           'filename' => 'INIC',
                           'options' => ['title' => 'Lista de INIC'],
                       ],            
                   ],


               // set a label for default menu
               'export' => [
                   'label' => 'Pagina',
                   'fontAwesome' => true,
               ],    

               'containerOptions'=>['style'=>['white-space' => 'nowrap']], // only set when $responsive = false
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

<?php } ?>

<?php 
$url = \yii\helpers\Url::to(['acta-transferencia-cab/autorizacion-masiva']) ;
//$url=\yii\helpers\Url::to(['presentar','id'=>$model->148]);
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
$('#btAutorizacion').click(function(){
var keys = $('#gridAutorizacion').yiiGridView('getSelectedRows');
if(keys != ''){

    krajeeDialog.confirm("¿Quiere autorizar esta presentación?", function (result) {
    if (result) { // ok button was pressed
         console.log(keys);
           $.ajax({
                url: '$url',
                type: 'post',
                data: {
                          ids: keys, 
                          _csrf : '$token'
                      },
                success: function (data) {
                    console.log(data);
                   // var obj = jQuery.parseJSON(data);
                    if(data){
                        $("#gridAutorizacion").yiiGridView("applyFilter");
                    }
                }
           });
           window.location.reload();
        }else { // confirmation was cancelled
        krajeeDialog.alert("Se cancelo la autorización");
        
    }
    });
    }else{
        krajeeDialog.alert("Debe seleccionar al menos un acta");

    }
});

JS;

    $this->registerJs($script);
?>