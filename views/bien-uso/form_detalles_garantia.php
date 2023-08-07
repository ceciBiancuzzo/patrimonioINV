<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;


//busco la cabecera para analizar el estado del producto, si este es estado presentado (1) ahi solamente calculo el saldo



?>
<div class="form_detalles_garantia" >
    <?php $form = ActiveForm::begin(['id' => 'detalles-garantia-form-id','options' => ['data-pjax' => true]]); ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'empresa' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->empresa]],
            'periodo_garantia' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->periodo_garantia]],
            'documento_respaldatorio' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->documento_respaldatorio]],
        ],
    ]);
    ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'fecha_inicio' =>  ['type'=>Form::INPUT_WIDGET, 
            'widgetClass'=> kartik\datecontrol\DateControl::class, 
            'options'=>[
                'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                'widgetOptions'=>[
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
            
                    ],
                ]]
            ],
            'fecha_fin' => [ 'type'=>Form::INPUT_WIDGET, 
            'widgetClass'=> kartik\datecontrol\DateControl::class, 
            'options'=>[
                'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                'widgetOptions'=>[
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                        
                    ],
                ]
                ],
            'observaciones' => ['type' => Form::INPUT_TEXTAREA, 'options' => [
                    'value' => $model->observaciones]],
        ]
    ]]);
    ?>
    
    <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
      <?php ActiveForm::end(); ?>

    <?php
    $urlDetalle = Url::to(['bien-uso/create-detalles-garantia']).'&id_bien_uso='.$model->id_bien_uso;
    $script = <<< JS
   $(document).ready(function(){
        $('#btnGuardarGarantia').click(function() {
            console.log("acaaaaaaaaaa");
            $(this).prop('disabled',true);
            $("#detalles-garantia-form-id").submit();
        });
        $('form#form-garantia').on('beforeSubmit',function(e){  
        var \$form = $(this);
        $.post(
            \$form.attr("action"),
            \$form.serialize()
        ).done(function(result){
            $("#detalles-garantia-form-id").find("#modalGarantia").html(result);
        });
       return false;
    });             
    // $("#modalGarantia").on("hidden.bs.modal", function () {
    //         window.location.href = "$urlDetalle";
    //     });
   }   )
JS;
    $this->registerJs($script);
    ?>
</div><!-- form_existencia_det -->
