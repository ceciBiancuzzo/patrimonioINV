<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;


//busco la cabecera para analizar el estado del producto, si este es estado presentado (1) ahi solamente calculo el saldo



?>
<div class="form_detalles_contables" >
    <?php $form = ActiveForm::begin(['id' => 'detalles-seguro-form-id','options' => ['data-pjax' => true]]); ?>
    <!-- ?= $form->field($model, 'id_bien_uso')->hiddenInput()->label(false); ?> -->
    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'empresa' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->empresa]],
            'numero_poliza' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->numero_poliza]],
            'condiciones' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->condiciones]],
             ]
        ],
    );
    ?>
     <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'forma_pago' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->forma_pago]],
            'prima' => ['type' => Form::INPUT_TEXT, 'options' => [
                        'value' => $model->forma_pago]],
            'importe' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->importe]],
        ]
    ]);
    ?>
    <?= 
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
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
            
    ]]]);
    ?>
    
    <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
      <?php ActiveForm::end(); ?>

    <?php
$urlDetalle = Url::to(['bien-uso/create-detalles-seguro']).'&id_bien_uso='.$model->id_bien_uso;
$script = <<< JS
$(document).ready(function(){
        $('#btnGuardarSeguro').click(function() {
            $(this).prop('disabled',true);
            $("#detalles-seguro-form-id").submit();
        });
        $('form#form-seguro').on('beforeSubmit',function(e){  
        var \$form = $(this);
        $.post(
            \$form.attr("action"),
            \$form.serialize()
        ).done(function(result){
            $("#detalles-seguro-form-id").find("#modalSeguro").html(result);
        });
       return false;
    });             
    
   }   ) 
JS;
    $this->registerJs($script);
    ?>
</div><!-- form_existencia_det -->
