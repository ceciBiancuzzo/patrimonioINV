<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model frontend\models\InicEspumosoCab */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'header' => '<h2>Detalles contables</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modalContables',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentContables'></div>";
Modal::end();  

// $disabled = false;
// if($_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_TECNICO){
//     $disabled = true;
// }else {
//     $disabled = false;
// }

//print_r($model);\Yii::$app->end();

$idBienUso = $model->id?$model->id:"";

//$idDet = $model->id?$model->id:"";
//print_r($model);\Yii::$app->end();
//$model_cabecera = \espumante\models\EspumanteTrasladosCab::find()->where(['id'=>$model->id])->all();

$model_detalle = \patrimonio\models\BienUsoContables::find()->where(['id_bien_uso'=>$idBienUso])->all();
//print_r($model_detalle[0]->volumen_tercero);
//print_r(count($model_detalle));\Yii::$app->end();
if(count($model_detalle)>0){
$idDet = $model_detalle[0]->id?$model_detalle[0]->id:"";
}
else{
    $idDet='';
}

$session = Yii::$app->session;
$visible = 'visible';
$disabled = false;

$botones_update
 = function ($url,$dataProviderContables) {
        
        return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
        ['title'=>'Editar Detalle','name' => 'btEditar', 
        'value' => \yii\helpers\Url::to(['bien-uso/update-detalles-contables','id'=>$dataProviderContables->id]),
        'class' => 'btn btn-info']);


};
$botones_delete = function ($url,$dataProviderContables) {

return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
        ['title'=>'Eliminar Detalle','name' => 'btEliminar',
        'value' => \yii\helpers\Url::to(['bien-uso/delete-detalles-contables','id'=>$dataProviderContables->id]),
        'class' => 'btn btn-danger']); 
};           
                    
        $botones_ver = function ($url,$dataProviderTercero) {return "   ".Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['title'=>'Ver tercero','name' => 'btVerTercero', 'value' => \yii\helpers\Url::to(['espumante-traslados-cab/view-tercero']).'&id='.$dataProviderTercero->id, 'class' => 'btn btn-info']);};
//        $botones_update = function ($url,$dataProviderTercero) {return "";};
  //      $botones_delete =   function ($url,$dataProviderTercero) {return "";};
        $visible = 'hidden';
//}
$token = Yii::$app->request->getCsrfToken();

?>

<div class="tercerto-index">
   <p align='left'>     
        <?php
       // if(count($model_detalle)>0 && ($_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_RESPONSABLE_TECNICO || $_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_RESPONSABLE || $_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_RESPONSABLE_HABILITADO)){
        
        echo Html::button('<span class="glyphicon glyphicon-plus"></span> Nuevo detalle contable', ['id' => 'modelButtonContables',
        'value' => \yii\helpers\Url::to(['bien-uso/create-detalles-contables','id_bien_uso'=>$model->id]), 
        'class' => 'btn btn-success','onClick'=>'$("#modalContables").modal("show")
        .find("#modalContentContables")
        .load($(this).attr("value"));']) ?>
     
   </p>
    <?= 
    GridView::widget([
            'dataProvider' => $dataProviderContables,
            //'filterModel' => $model,
            'columns' => [
                'id',
                ['attribute'=>'ejercicio','label'=>'Ejercicio'],
                ['attribute'=>'tipo_adquisicion','label'=>'Tipo de adquisición'],
                ['attribute'=>'motivo','label'=>'Motivo'],
                ['attribute'=>'entidad_cedente','label'=>'Entidad cedente'],
                ['attribute'=>'dominio','label'=>'Dominio'],
                ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{update} {delete} {view}',
                    'buttons'=>[
                        'view' => $botones_ver,
                        'update' => $botones_update,
                        'delete' => $botones_delete,
                    ],
                ],
            ],
            'panel' => [
               'type' => GridView::TYPE_INFO,
               'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"> </i> Detalles contables</h3>',
           ],  
            'responsive' => true,
            'containerOptions'=>['style'=> ['white-space' => 'nowrap']], // only set when $responsive = false
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],        
            'hover' => true,
            'bordered' => true,
            'striped' => false,
            'condensed' => true,
            'hover' => true,
            'showPageSummary' => false,
            'persistResize' => false,
            'exportConfig' => true,
           ]);?>
    

<?php 
$script = <<< JS
    $("button[name=\'btVerDetallesContables\']").click(function(){
            $("#modalContables").modal("show")
                    .find("#modalContentContables")
                   .load($(this).attr("value")+'&id=$idBienUso');
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
        $("#modalContablesHeader").find("h2").html("Modificar detalle");
        $("#modalContables").modal("show")
            .find("#modalContentContables")
            .load($(this).attr("value"));
           
    });
    
    
JS;

$this->registerJs($script);
?>

</div>
