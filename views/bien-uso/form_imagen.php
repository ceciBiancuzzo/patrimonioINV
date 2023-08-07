<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use kartik\builder\Form;
use espumante\models\ParametrosInscriptos as EspumanteParametrosInscriptos;


// echo FileInput::widget([
//     'name' => 'attachments', 
//     'options' => ['multiple' => true], 
//     'pluginOptions' => ['previewFileType' => 'any'],
    
// ]);
//$variedad = espumante\models\ParametrosVariedad::find()->all();
?>
<div class="form_existencia_det" >

    <?php
    $form1 = ActiveForm::begin([
                'action' => ['upload-file'],
                'options' => ['enctype' => 'multipart/form-data'] // important
    ]);
    ?>


    <?php
  
//    //aqui envio en un input oculto un id
    echo $form1->field($model, 'id')->hiddenInput()->label(false);
    echo FileInput::widget([
        'model' => $modelFile,
        'attribute' => 'file[]',
        'options' => ['multiple' => true],
        'pluginOptions' => ['previewFileType' => 'any'],
    ]);
    
//    echo $form1->field($model, 'id_si_marcas')->hiddenInput()->label(false);
    // ?>
     <?php
    // // aqui esta el input de tipo file
    // echo Form::widget([
    //     'id' => 'registro-salida',
    //     'model' => $model,
    //     'form' => $form1,
    //     'columns' => 1,
    //     'attributes' => [
    //         'imagen_bien' => [
    //             'label' => 'Seleccione una foto',
    //             'type' => Form::INPUT_WIDGET,
    //             'widgetClass' => FileInput::class,
    //             'name' => 'attachment_50',
    //             'options' =>[
    //               'pluginOptions' => [
    //                     'showPreview' => true,
    //                     'showCaption' => true,
    //                     'showRemove' => false,
    //                     'showUpload' => true,
    //                     'allowedFileExtensions' => [
    //                         'jpg'
    //                     ],
    //                     'maxFileSize'=>500
                    
    //                 ],  
    //             ],
               
    //         ]
    //     ]
    // ]);
    // ?>
     <?php
    ActiveForm::end();

    ?>

</div><!-- form_existencia_det -->


<?php
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
    $(document).ready(function() {
      var uvaConsumo = Number($('#cosechadestinouvadet-kg_uva_consumo').val());
        var uvaSecado = Number($('#cosechadestinouvadet-kg_uva_secado').val());
        var suma = 0;
        suma = uvaConsumo + uvaSecado;
        $('#cosechadestinouvadet-totales').val(suma); 
    });    
    $("#cosechadestinouvadet-id_nroins_vinedo").blur(function(){
        traerDatosInscripto($(this).val());    
    });
    $("#cosechadestinouvadet-id_nroins_bodega").blur(function(){
       traerDatosInscripto1($(this).val());    
    });
    
    $("#cosechadestinouvadet-kg_uva_secado").blur(function(){
        var uvaConsumo = Number($('#cosechadestinouvadet-kg_uva_consumo').val());
        var uvaSecado = Number($('#cosechadestinouvadet-kg_uva_secado').val());
        var suma = 0;
        suma = uvaConsumo + uvaSecado;
        $('#cosechadestinouvadet-totales').val(suma);
    });
        
        
    $("#cosechadestinouvadet-kg_uva_elaboracion").blur(function(){
        var uvaElaboracion = Number($('#cosechadestinouvadet-kg_uva_elaboracion').val());
        if (uvaElaboracion > 0) {
    var bodega = $('#cosechadestinouvadet-id_nroins_bodega').val();
        if (bodega == ' ') {
    krajeeDialogCust.alert("A cargado kg de UVA de Elaboracion, no puede estar el Nº de Inscripto de la Bodega vacio");
        }
    }
    });
       
        
    $("button[id=\'btnGuardar\']").click(function(){
        var uvaElaboracion = Number($('#cosechadestinouvadet-kg_uva_elaboracion').val());
        if (uvaElaboracion > 0) {
        var bodega = $('#cosechadestinouvadet-id_nroins_bodega').val();
        if (bodega == '') {
             krajeeDialogCust.alert("A cargado kg de UVA de Elaboracion, no puede estar el Nº de Inscripto de la Bodega vacio");
             return false;
            }
        }
        if (uvaElaboracion <= 0) {
            if (bodega != ''){
                 krajeeDialogCust.alert("No ha cargado kg de UVA de Elaboracion, no puede estar el Nº de Inscripto de la Bodega con algun Valor");
                 $('#cosechadestinouvadet-id_nroins_bodega').val('');
                 $('#cosechadestinouvadet-razon_social_bodega').val('');
                 return false;
            }
        }
        
       $('#cosechaDestinoUvaDet').submit();
 
    });
        
JS;
$this->registerJs($script);
?>
