<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use patrimonio\parametros\PatrimonioEstadosFormularios;
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 
if (strpos($perfil, 'Administrador')== 1){
    $disabled = false;
}else{
    $disabled = true;
}

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Información',
    ]
    ]);

    //modal para el create
  
  Modal::begin([
    'header' => '<h2></h2>',
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

    //modal para el update

  Modal::begin([
    'header' => '<h2></h2>',
    'headerOptions' => ['id' => 'modalDetalleHeader'],
    'id' => 'modalContentEstado',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
  ]);
  echo "<div id='modalContentEstado'>Cargando... Espere...</div>";
  Modal::end();
$titulo = 'Estados';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="acta-recepcion-cabecera-index" >
    
    </div>

   <?php
     
        $opcion_update = function ($url,$dataProvider) {


            return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                        ['title'=>'Editar Estado','name' => 'btEditar', 
                                        'value' => \yii\helpers\Url::to(['patrimonio-estado-interno/update','id'=>$dataProvider->id]),
                                        'class' => 'btn btn-info']);

        };

     $opcion_delete = function ($url,$dataProvider) {

           return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                        ['title'=>'Eliminar Estado','name' => 'btEliminar',
                                        'value' => \yii\helpers\Url::to(['patrimonio-estado-interno/delete','id'=>$dataProvider->id]),
                                        'class' => 'btn btn-danger']); 
       };

     

    //  $opcion_update = function ($url,$dataProvider) {
    //      return ""; }   ;
    //  $opcion_delete =    function ($url,$dataProvider) {
    //                                  return "";
    //                             }   ;
     
    
                 
        $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            'id',
            'denominacion',
            'descripcion',
         
            // ['class' => '\kartik\grid\CheckboxColumn',
            // //el check solo esta disponible para las ddjj en estado borrador
            // 'header' => 'Presentar',
           
            // ],
            
            ['class' => 'kartik\grid\ActionColumn',
            'template' => ' {update}',
            'buttons' => [
               'update'=>$opcion_update,
               //'delete' => $opcion_delete, {delete}                 
            ], 
            ]
        ];   
        
    ?>

    <div class="form-group" align="right">

    <?php
        if (strpos($perfil, 'Administrador')== 1){

     echo( Html::button('
     <span class="glyphicon glyphicon-pencil"></span> Nueva Estado', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['patrimonio-estado-interno/create']), 'class' => 'btn btn-success',]) );
        }
     ?>

        
    </div>

    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridAutorizacion',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'panel' => [
                'type' => GridView::TYPE_INFO,
                'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de estados del Bien</h3>',
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
            'containerOptions'=>['style'=>['white-space' => 'nowrap']],// only set when $responsive = false
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
$url = \yii\helpers\Url::to(['patrimonio-estado-interno/create']) ;
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
$("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value"));
            

    });


    $("button[name=\'btEliminar\']").click(function(){
        var url_detalle = $(this).attr("value");
        krajeeDialog.confirm("Desea eliminar el estado?", function (result) {

            if(result){
                $.ajax({
                    url: url_detalle,
                    type: "post",
                    data: {
                              _csrf : "$token"
                          },
                    success: function (data) {                                         
                    }
                });
            }
        });
    });
    $("button[name*=\'btEditar\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Modificar Marca");
        $("#modalContentEstado").modal("show")
            .find("#modalContentEstado")
            .load($(this).attr("value"));
           
    });
$('#btAutorizacion').click(function(){
krajeeDialog.confirm("¿Desea presentar este Acta de Recepcion?", function (result) {
    if (result) { // ok button was pressed
        var keys = $('#gridAutorizacion').yiiGridView('getSelectedRows');
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
    } else { // confirmation was cancelled
        krajeeDialog.alert("Se cancelo la presentacion de Acta de Recepcion");
        
    }
});
});

JS;

$this->registerJs($script);
?>