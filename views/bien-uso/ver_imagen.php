<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;

echo \kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'options' => ['multiple' => true]
    ]
]);
//,'width'=>'700','class'=>"card-mg-top"
//echo $modeloBien->ruta_archivo;die();
?>

<?php

  foreach($modelImagenes as $imagen){?>
        <?=

Html::img('@web/fotos/'.$imagen->ruta_archivo, ['alt'=>'imagen','width'=>'700','class'=>"card-mg-top"]) ?>

<?php
        echo Html::button('Eliminar', ['name' => 'btEliminar','value' => \yii\helpers\Url::to(['bien-uso/eliminar-imagen', 'id'=>$imagen->id]), 'class' => 'btn btn-success']) ;?>

<?php } 
$token = Yii::$app->request->getCsrfToken();

$script = <<< JS
$("button[name=\'btEliminar\']").click(function(){
        var url_detalle = $(this).attr("value");
        krajeeDialog.confirm("Desea eliminar el Detalle?", function (result) {
           if(result){
                $("#gridDetalle-pjax").addClass("kv-grid-loading");
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
JS;
$this->registerJs($script);

?>

