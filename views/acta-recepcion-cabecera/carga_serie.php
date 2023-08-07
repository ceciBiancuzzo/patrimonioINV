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
                'id' => [
                    'label' => 'Bien Uso',
                    'type' => Form::INPUT_TEXT,
                        'id' => 'id',
                    'options' => [
                        'value'=>$model->strBien,'readOnly'=>true,
                    ],
                ],
                'nro_serie' => [
                    'label' => 'Número de serie',
                    'type' => Form::INPUT_TEXT,
                        'id' => 'número de serie',
                    'options' => [
                        'value'=>$model->nro_serie,
                    ],
                ],      
            ],   
        ]);
    
    ?>

    <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- form_existencia_det -->

<?php 
$script = <<< JS
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