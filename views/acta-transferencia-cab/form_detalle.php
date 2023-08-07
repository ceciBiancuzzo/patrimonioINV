<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model espumante\models\EspumanteMovimientosInternosDet */
/* @var $form ActiveForm */

$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
  
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 
    if (strpos($perfil, 'Auditor')== 1) {
        $disable = true;
    } 

//if (strpos($perfil, 'Administrador')== 0) {
    $tipoBien = patrimonio\models\BienUso::find()->where(['IN','id_estado_interno' ,[2,3,4,5,6,7,8,9]])->andWhere(['id_dependencia' => $seccion])->andWhere(['transf_actual' =>false])->all();    // } 
// if (strpos($perfil, 'Administrador')== 1) {
//     $tipoBien = patrimonio\models\BienUso::find()->where(['!=','id_estado_interno',1])->andWhere->all();
// }
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
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
    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'id_cab')->hiddenInput()->label(false); ?>
    
<!-- ]); -->
    <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[ 
                'id_bien_uso' => [
                    'label' => 'Bien Uso',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'id_bien_uso',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($tipoBien, 'id','strBien'), 'pluginOptions' => ['allowClear' => true],
                        'options' => ['placeholder' => 'Seleccione Bien uso',]
                    ],
                ],
                'id_condicion' => [
                    'label' => 'Condicion Bien',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'id_condicion',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($condicionBien, 'id', 'descripcion'), 'pluginOptions' => ['allowClear' => true],
                        'options' => ['placeholder' => 'Seleccione  condición del Bien',]
                    ],
                ],         
                'observaciones'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'']],
  
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