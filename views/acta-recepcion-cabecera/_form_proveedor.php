
<?php
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;
use patrimonio\parametros\Proveedor;

echo Dialog::widget([
    'libName' => 'krajeeDialog', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
]);
$url = Url::to(['proveedor/create-proveedor']);

?>
<script>
    //Funcion para agregar la marca
    function sendCreateProveedor(){
       
        krajeeDialog.confirm("Desea agregar el proveedor?", function (result) {    
        if(result){
        var denominacion = $("#proveedor-denominacion").val()
        console.log(denominacion);
        $.post( '<?=  $url ?>',
                {denominacion: denominacion},
                function( data ) {
                    if(data){
                        console.log(data);
                        var objdata = JSON.parse(data);
                        $("#actarecepciondetalle-id_proveedor").append($('<option>', {value:objdata.id, text:objdata.denominacion})).trigger('change');
                        $('#popover-proveedor').hide();
                        $('#proveedor-denominacion').val("");


                    }
                });  
                krajeeDialog.alert("Se agrego el proveedor!.");
                
                         return;
            }else{
                krajeeDialog.alert("No se agrego el proveedor.");
                return;
            }
     

                });

    }
    $('#btnProveedor').click(function(){
        $("#btnProveedor").prop('disabled',true);

        $('#form-proveedor').submit();

        
    });

</script>
<?php
PopoverX::begin([
    'placement' => PopoverX::ALIGN_BOTTOM,
    'toggleButton' => ['label'=>' Nuevo proveedor', 'class'=>'btn btn-success','id'=>'btnNuevaMarca'],
    'header' => '<i class="glyphicon glyphicon-log-in"> </i> Ingresar datos del proveedor',
    'size' => PopoverX::SIZE_LARGE,
    'type' => PopoverX::TYPE_SUCCESS,
    'id' => 'popover-proveedor',
    'footer' => Html::submitButton('<span class="glyphicon glyphicon-check"></span> Agregar proveedor', [
            'id' => 'btnProveedor',
            'class' =>'btn btn-success', 
            'onclick' => 'sendCreateProveedor()'

            
        ]) 
        
]);
// form with an id used for action buttons in footer

$formProveedor = ActiveForm::begin(['id'=>'form-proveedor','action'=>['proveedor/create-proveedor'],'fieldConfig'=>['showLabels'=>false], 'options' => ['id'=>'form-proveedor']]);
$modelProveedor= new Proveedor();
?>
    <?= Form::widget([    
                        'model'=>$modelProveedor,
                        'form'=>$formProveedor,
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