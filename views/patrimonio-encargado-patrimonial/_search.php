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


$seccion = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=> 'A'])->all();
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
         

            'id_encargado'=> [
                'label' => 'Usuario Asignado 1',
                'id' => 'id_usuario_bien',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                ] 
            ],

            'id_encargado2'=> [
                'label' => 'Usuario Asignado 2',
                'id' => 'id_usuario_bien',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                ] 
            ],
            

          
            
      

     
        ]
   
        
    ]);
    ?> 

<?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
         

          
            

            'id'=> [
                'label' => 'Dependencia',
                'id' => 'id',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($seccion, 'id', 'strDependencia'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Area',]
                ] 
            ],
            
      

     
        ]
   
        
    ]);
    ?> 




    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-10"><span><?= Html::Button('<span class="glyphicon glyphicon-search"></span> Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
        <div class="col-sm-1">
        
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
