<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model frontend\models\InicEspumosoCab */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'header' => '<h2>Detalle de seguro</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modalSeguro',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentGarantia'></div>";
Modal::end();  
// $disabled = false;
// if($_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_TECNICO){
//     $disabled = true;
// }else {
//     $disabled = false;
// }

//print_r($model);\Yii::$app->end();

$idBienUso = $model->id?$model->id:"";

$model_detalle = \patrimonio\models\BienUsoSeguro::find()->where(['id_bien_uso'=>$idBienUso])->all();
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
= function ($url,$dataProviderSeguro) {
       
       return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
       ['title'=>'Editar Detalle','name' => 'btEditar', 
       'value' => \yii\helpers\Url::to(['bien-uso/update-detalles-seguro','id'=>$dataProviderSeguro->id]),
       'class' => 'btn btn-info']);


};
$botones_delete = function ($url,$dataProviderSeguro) {

return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
       ['title'=>'Eliminar Detalle','name' => 'btEliminar',
       'value' => \yii\helpers\Url::to(['bien-uso/delete-detalles-seguro','id'=>$dataProviderSeguro->id]),
       'class' => 'btn btn-danger']); 
};                 $botones_ver = function ($url,$dataProviderTercero) {return "   ".Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['title'=>'Ver tercero','name' => 'btVerTercero', 'value' => \yii\helpers\Url::to(['espumante-traslados-cab/view-tercero']).'&id='.$dataProviderTercero->id, 'class' => 'btn btn-info']);};
            // $botones_update = function ($url,$dataProviderTercero) {return "";};
            // $botones_delete =   function ($url,$dataProviderTercero) {return "";};
        $visible = 'hidden';
//}
$token = Yii::$app->request->getCsrfToken();

?>

<div class="tercerto-index">
   <p align='left'>     
        <?php
       echo Html::button('Agregar detalles de seguro', ['id' => 'modelButtonGarantia',
       'value' => \yii\helpers\Url::to(['bien-uso/create-detalles-seguro','id_bien_uso'=>$model->id]), 
       'class' => 'btn btn-success','onClick'=>'$("#modalSeguro").modal("show")
       .find("#modalContentGarantia")
       .load($(this).attr("value"));']) ?>
     
   </p>
    <?= 
    GridView::widget([
            'dataProvider' => $dataProviderSeguro,
            //'filterModel' => $model,
            'columns' => [
                'id',
              //  ['attribute'=>'ejercicio','label'=>'CUIT'],
                ['attribute'=>'empresa','label'=>'Empresa'],
                ['attribute'=>'numero_poliza','label'=>'Número de póliza'],
                ['attribute'=>'forma_pago','label'=>'Forma de pago'],
                ['attribute'=>'prima','label'=>'Prima'],
                ['attribute'=>'importe','label'=>'Importe'],
                ['attribute'=>'fecha_inicio','label'=>'Fecha de inicio'],
                ['attribute'=>'fecha_fin','label'=>'Fecha de finalización'],
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
               'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"> </i> Detalles seguro</h3>',
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
    
    $("button[name=\'btVerdetalledeseguro\']").click(function(){
            $("#modalSeguro").modal("show")
                    .find("#modalContentGarantia")
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
        $("#modalSeguroHeader").find("h2").html("Modificar detalle");
        $("#modalSeguro").modal("show")
            .find("#modalContentSeguro")
            .load($(this).attr("value"));
           
    });
    
    
    
JS;

$this->registerJs($script);
?>

</div>
