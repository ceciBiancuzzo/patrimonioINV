<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model espumante\models\EspumanteTrasladosTercerceros */
/* @var $form ActiveForm */


?>
<div class="form_detalles_contables">

    <?php 
     yii\widgets\Pjax::begin(['id' => 'detalles-ajax']);
    $form = ActiveForm::begin(['id'=>'detalles-contables-form-id','options' => ['data-pjax' => true]]); ?>
    <!-- ?= $form->field($model, 'id_det')->hiddenInput()->label(false); ?> -->
    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

    <?= Form::widget([    
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>2,
                        'attributes'=>[ 
                                        'ejercicio'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                                        'tipo_adquisicion'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                                       
                            ]
                        ]);
                    ?>
    <?= Form::widget([    
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>2,
                        'attributes'=>[ 
                                        'motivo'=>['label'=>'Motivo','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                                        'submotivo'=>['label'=>'Submotivo','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                            ]
                        ]);
                    ?>
    <?= Form::widget([    
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>2,
                        'attributes'=>[ 
                                        'entidad_cedente'=>['label'=>'Entidad cedente','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                                        'dominio'=>['label'=>'Dominio','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                            ]
                        ]);
                    ?>
    
        <div class="form-group">
            <?= Html::button('<span class="glyphicon glyphicon-check"></span> Guardar ', ['id' => 'btnGuardarDetallesContables', 'class' => 'btn btn-primary'])?>
        </div>
        <?php ActiveForm::end(); 
    
     ?>

</div>

<?php 
$urlDetalle = Url::to(['bien-uso/create-detalles-contables']).'&id_bien_uso='.$model->id_bien_uso;
$script = <<< JS
    $(document).ready(function(){
        $('#btnGuardarDetallesContables').click(function() {
            $(this).prop('disabled',true);
            $("#detalles-contables-form-id").submit();
        });
        $('form#form-contables').on('beforeSubmit',function(e){  
        var \$form = $(this);
        $.post(
            \$form.attr("action"),
            \$form.serialize()
        ).done(function(result){
            $("#detalles-contables-form-id").find("#modalContentContables").html(result);
        });
       return false;
    });          
        // $("#modalContables").on("hidden.bs.modal", function () {
        //     window.location.href = "$urlDetalle";
        // });
        
        
   });
   
JS;
$this->registerJs($script);
yii\widgets\Pjax::end();
?>