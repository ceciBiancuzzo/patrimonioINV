<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model frontend\models\InicEspumosoCab */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'header' => '<h2>Detalles de la garantía</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modalGarantia',
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



$idBienUso = $model->id?$model->id:"";

$model_detalle = \patrimonio\models\BienUsoGarantia::find()->where(['id_bien_uso'=>$idBienUso])->all();

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
= function ($url,$dataProviderGarantia) {
       
       return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
       ['title'=>'Editar Detalle','name' => 'btEditar', 
       'value' => \yii\helpers\Url::to(['bien-uso/update-detalles-garantia','id'=>$dataProviderGarantia->id]),
       'class' => 'btn btn-info']);


};
$botones_delete = function ($url,$dataProviderGarantia) {

return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
       ['title'=>'Eliminar Detalle','name' => 'btEliminar',
       'value' => \yii\helpers\Url::to(['bien-uso/delete-detalles-garantia','id'=>$dataProviderGarantia->id]),
       'class' => 'btn btn-danger']); 
};         
        $botones_ver = function ($url,$dataProviderTercero) {return "   ".Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['title'=>'Ver tercero','name' => 'btVerTercero', 'value' => \yii\helpers\Url::to(['espumante-traslados-cab/view-tercero']).'&id='.$dataProviderTercero->id, 'class' => 'btn btn-info']);};
        // $botones_update = function ($url,$dataProviderTercero) {return "";};
        // $botones_delete =   function ($url,$dataProviderTercero) {return "";};
        $visible = 'hidden';
//}
$token = Yii::$app->request->getCsrfToken();

?>

<div class="tercerto-index">
   <p align='left'>     
        <?php
       // if(count($model_detalle)>0 && ($_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_RESPONSABLE_TECNICO || $_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_TECNICO_RESPONSABLE || $_SESSION['flagTecnico'] == \common\models\helpers\AppHelpers::FLAG_RESPONSABLE_HABILITADO)){
        
        
        echo Html::button('Nuevo detalle de garantía', ['id' => 'modelButtonGarantia',
        'value' => \yii\helpers\Url::to(['bien-uso/create-detalles-garantia','id_bien_uso'=>$model->id]), 
        'class' => 'btn btn-success','onClick'=>'$("#modalGarantia").modal("show")
        .find("#modalContentGarantia")
        .load($(this).attr("value"));']) ?>
     
   </p>
    <?= 
    GridView::widget([
            'dataProvider' => $dataProviderGarantia,
            //'filterModel' => $model,
            'columns' => [
                'id',
                ['attribute'=>'empresa','label'=>'Empresa'],
                ['attribute'=>'periodo_garantia','label'=>'Periodo de garantía'],
                ['attribute'=>'documento_respaldatorio','label'=>'Documento'],
                ['attribute'=>'fecha_inicio','label'=>'Inicio'],
                ['attribute'=>'fecha_fin','label'=>'Finalización'],
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
               'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"> </i> Detalles garantía</h3>',
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
    
    $("button[name=\'btVerGarantía\']").click(function(){
            $("#modalGarantia").modal("show")
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
        $("#modalGarantiaHeader").find("h2").html("Modificar detalle");
        $("#modalGarantia").modal("show")
            .find("#modalContentGarantia")
            .load($(this).attr("value"));
           
    });
    
    
    
JS;

$this->registerJs($script);
?>

</div>
