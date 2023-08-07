<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\DateControl\DateControl;
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
  
  Modal::begin([
    'header' => '<h2>Nueva Marca</h2>',
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
  Modal::begin([
    'header' => '<h2></h2>',
    'headerOptions' => ['id' => 'modalDetalleHeader'],
    'id' => 'modalContentMarca',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
  ]);
  echo "<div id='modalContentMarca'>Cargando... Espere...</div>";
  Modal::end();
$titulo = 'Marcas';
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
   
   <?php
    

        $opcion_update = function ($url,$dataProvider) {


            return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                        ['title'=>'Editar Marca','name' => 'btEditar', 
                                        'value' => \yii\helpers\Url::to(['patrimonio-marca/update','id'=>$dataProvider->id]),
                                        'class' => 'btn btn-info']);

        };

     $opcion_delete = function ($url,$dataProvider) {

           return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                        ['title'=>'Eliminar Marca','name' => 'btEliminar',
                                        'value' => \yii\helpers\Url::to(['patrimonio-marca/delete','id'=>$dataProvider->id]),
                                        'class' => 'btn btn-danger']); 
       };

     

    //  $opcion_update = function ($url,$dataProvider) {
    //      return ""; }   ;
    //  $opcion_delete =    function ($url,$dataProvider) {
    //                                  return "";
    //                             }   ;
     
    
                 
        $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
        
            'denominacion',
        
            ['class' => 'kartik\grid\ActionColumn',
            'template' => ' {update}{delete}',
            'buttons' => [
               'update'=>$opcion_update,
               'delete' => $opcion_delete,
                              
            ], 
            ]
        ];   
        
    ?>

    <div class="form-group" align="right">

    <?php
      if (strpos($perfil, 'Administrador')== 1){
        echo( Html::button('
        <span class="glyphicon glyphicon-pencil"></span> Nueva Marca', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['patrimonio-marca/create-marca']), 'class' => 'btn btn-success',]) );
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
                'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de Marcas</h3>',
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
$url = \yii\helpers\Url::to(['patrimonio-marca/create']) ;
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
        krajeeDialog.confirm("Desea eliminar el detalle?", function (result) {

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
        $("#modalDetalleHeader").find("h2").html("Modificar detalle");
        $("#modalContentMarca").modal("show")
            .find("#modalContentMarca")
            .load($(this).attr("value"));
           
    });


JS;
$this->registerJs($script);
?>