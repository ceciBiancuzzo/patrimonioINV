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
use patrimonio\models\PatrimonioEstadoInterno;

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm 
*/

$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$bienes= patrimonio\models\BienUso::find()->all();
$areas= patrimonio\parametros\PatrimonioArea::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();


?>
<?php $form = ActiveForm::begin(['id' => 'registro_solicitud']); ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'id_solicitud_cab')->hiddenInput()->label(false); ?>
        </div>
        <?=
    /*crear detalle*/
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'id_bien_uso' => [
                'label' => 'Bien Uso',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'id_bien_uso',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($bienes, 'id','strBien'),'pluginOptions' => ['allowClear' => true],
                    
                ],
            ],

            'cantidad_solicitada'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']
                ],
            
            
            
            'observaciones'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'']
                ],
            ],
            
        ]);
    ?> 
    </div>
</div>  
   
<div class="form-group">
        
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>

<?php
$token = Yii::$app->request->getCsrfToken();

$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    
    
    $("#btRechazar").click(function(){
    
   });
JS;
$this->registerJs($script);
?>

