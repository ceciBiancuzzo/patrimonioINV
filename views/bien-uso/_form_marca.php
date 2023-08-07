
<?php
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use patrimonio\parametros\PatrimonioMarca;
use yii\helpers\Html;
use kartik\builder\Form;
use yii\helpers\Url;
use kartik\dialog\Dialog;

echo Dialog::widget([
    'libName' => 'krajeeDialog', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
]);
$url = Url::to(['patrimonio-marca/create']);

?>
<script>
    //Funcion para agregar la marca
    function sendCreateMarca(){
       
        $('#btnMarca').prop("disabled",true)  //Deshabilito boton
        $('#btnMarca').text("Marca cargada")  //Modifico texto del boton
        krajeeDialog.confirm("Desea agregar la marca?", function (result) {    
        if(result){
        var denominacion = $("#patrimoniomarca-denominacion").val()
        console.log(denominacion);
        $.post( '<?=  $url ?>',
                {denominacion: denominacion},
                function( data ) {
                    if(data){
                        console.log(data);
                        var objdata = JSON.parse(data);
                        $("#bienuso-id_marca").append($('<option>', {value:objdata.id, text:objdata.denominacion})).trigger('change');
                        $('#popover-marca').hide();
                        $('#patrimoniomarca-denominacion').val("");
                    }
                });  
                krajeeDialog.alert("Se agrego la marca exitosamente.");
                         return;
            }else{
                krajeeDialog.alert("No se agrego la marca.");
                return;
            }
                });
            
    }
  
</script>
<?php
PopoverX::begin([
    'placement' => PopoverX::ALIGN_BOTTOM,
    'toggleButton' => ['label'=>' Nueva Marca', 'class'=>'btn btn-success','id'=>'btnNuevaMarca'],
    'header' => '<i class="glyphicon glyphicon-log-in"> </i> Ingresar datos de la marca',
    'closeButton' => ['id'=>'btnCerrar'],    
    'size' => PopoverX::SIZE_LARGE,
    'type' => PopoverX::TYPE_SUCCESS,
    'id' => 'popover-marca',
    'footer' => Html::submitButton('<span class="glyphicon glyphicon-check"></span> Agregar marca', [
            'id' => 'btnMarca',
            'class' =>'btn btn-success', 
            'onclick' => 'sendCreateMarca()'

            
        ]) 
]);
// form with an id used for action buttons in footer

$formMarca = ActiveForm::begin(['id'=>'form-marca','action'=>['patrimonio-marca/create'],'fieldConfig'=>['showLabels'=>false], 'options' => ['id'=>'form-marca']]);
$modelMarca= new PatrimonioMarca();
?>
    <?= Form::widget([    
                        'model'=>$modelMarca,
                        'form'=>$formMarca,
                        'columns'=>2,
                        'attributes'=>[
                        // 'id'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'ID']],
                         'denominacion'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Denominación']],
                        ]
                        ]);
                    ?>        
         
<?php

ActiveForm::end();
//    die();
PopoverX::end();
?>