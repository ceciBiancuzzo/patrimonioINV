<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use parametros\models\ParametrosDelegaciones;
use gestion_personal\models\PersonalOrganigrama;

/* patrimonio\views\trazabilidad_bien */

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */

$estadoBien = patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$tipoBien = patrimonio\models\BienUso::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$area= patrimonio\parametros\PatrimonioArea::find()->all();

$estadoFormulario= patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$agente= gestion_personal\models\PersonalAgente::find()->all();
$Seccion= gestion_personal\models\PersonalOrganigrama::find()->all();

?>

<div class="evento-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'id' => 'formprincipal'
    ]);
    ?>



<?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'anio' => [
                'label' => 'Año',
                'type' => Form::INPUT_TEXT,
               
                'id' => 'anio',
                'options' => [
                
                ],
            ],
            
            
                
        
        
        ]
          
           
         
        
    ]);
    ?> 


  
    
    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-10"><span><?= Html::Button('<span class="glyphicon glyphicon-search"></span> Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
        <div class="col-sm-1">
        <?php
            echo Html::a(
                    '<span class="glyphicon glyphicon-question-sign"></span>', '@web/pdf/Manual-de-Usuario-Sistema-Patrimonio.pdf', [
                'class' => 'btn btn-primary',
                'title' => '¿Necesitas ayuda?',
                'target' => '_blank',
                'data-toggle' => 'tooltip'
                    ]
            );
            ?>
        </div>
        <br>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('#btnConsultar').click(function(){
     
           
        
        
     
        
                $('#formprincipal').submit();
        
            
    });
JS;

$this->registerJs($script);
?>
