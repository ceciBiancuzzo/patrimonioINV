<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model espumante\models\EspumanteMovimientosInternosDet */
/* @var $form ActiveForm */
//  

$tipoBien = patrimonio\models\BienUso::find()->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
echo \kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
    ]);

?>
<div class="form_autoriza_det_transf" >
    <?php $form = ActiveForm::begin(['id'=>'detalle-transf-form-id']); ?>
    <!-- campos ocultos -->
    
<!-- ]); -->
    <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[ 
                'nro_inventario' => [
                    'label' => 'Indique número de inventario',
                    'type' => Form::INPUT_TEXT,
                        'id' => 'número de serie',
                    
                ],      
                'id' => [
                    'label' => 'Bien Uso',
                    'type' => Form::INPUT_TEXT,
                        'id' => 'id',
                    'options' => [
                       'readOnly'=>true,
                    ],
                ],
                
            ],   
        ]);
    
    ?>
  <div class="form-group" align='center'>
         
         <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Agregar Sobrante', ['id'=>'btAgregar','class' => 'btn btn-primary']) ?>
         
 </div> 
 
    <?php ActiveForm::end(); ?>

</div><!-- form_existencia_det -->

<?php 
$url = Url::to(['informe-patrimonial/datos-bien']);

$script = <<< JS
$(document).ready(function() {
    $('#btAgregar').prop('disabled',true);

    });   
  function traerBien(inventario){
        


        if($('#bienuso-nro_inventario').val().trim()!=''){     
      
            $.ajax({
                type: "GET",
                url:"$url",
                data: "nro_inventario="+inventario,
               
                success: function (response) {     
                    var datos = jQuery.parseJSON(response);
                    var datosBien = datos.datos;
                    var datosError = datos.error;
                    console.log(datosBien)
                    if(datosError == ''){
                        const str= 'Número INV: '+datosBien.nro_inventario+' - '+' Bien: '+datosBien.tipo_bien+' - '+' Area: '+ datosBien.dependencia+' - Encargado: '+datosBien.encargado 
                        $("#bienuso-id").val(str);
                    }else{
                        krajeeDialog.alert("El numero de inventario indicado no se ha encontrado.");
                       // $("#btnGuardar").prop('disabled',true)
                        return false;   
                    }
                   
                    $('#btAgregar').prop('disabled',false);

                }
                });      
        } else {
            // alert('nada');
            krajeeDialog.alert("Indique un numero de inventario.");
            return false;           
        }    
    }

    $("#bienuso-nro_inventario").change(function(){

        traerBien($('#bienuso-nro_inventario').val()); 
    });
 $('form#existencia-det-form-id').on('beforeSubmit',function(e){
        var o = {};
        
        if ($("#cosechaautorizaciudetalle-nro-ciu").val() == null){
            alert("No se ha declarado CIU" );
            return false;        
        }
   });
JS;
$this->registerJs($script);
?>
