<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use gestion_personal\models\PersonalAgente;
/* @var $this yii\web\View */
/* @var $model patrimonio\models\AsignacionDeBienes */
/* @var $form yii\widgets\ActiveForm */
$area = Yii::$app->user->identity->personalAgente->id_seccion;
$tecnico= gestion_personal\models\PersonalAgente::find()->where(['IN','id_seccion', [2030,2033,2035,1012,1022,1032,1062,1072,1092,1102,1112,1142,1146]])->all();
$tecnicos= gestion_personal\models\PersonalAgente::find()->where(['IN','id_seccion', [2030,2033,2035,1012,1022,1032,1062,1072,1092,1102,1112,1142,1146]])->all();
?>
<div class="evento-createsoli">
<?php $form = ActiveForm::begin(['id' => 'revision_tecnica']);?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            Asignar técnicos
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
         <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'tecnico_revision1' => [
                    'label' => 'Tecnico 1',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'tecnico_revision1',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($tecnicos, 'id','strAgente'),
                        'options' => ['placeholder' => 'Seleccione Tecnico'],
                        
                    ]
                ],
                'tecnico_revision2' => [
                    'label' => 'Tecnico 2', 
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'tecnico_revision2',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($tecnicos, 'id','strAgente'),
                        'options' => ['placeholder' => 'Seleccione Tecnico'],
                    ]            
                ], 
            ]
        ]);
        ?>
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'comentario_revision' => [
                    'label' => 'Observaciones',
                    'type' => Form::INPUT_TEXT,
                    'id' => 'comentario_revision',
                    'options' => [
                        'placeholder' => 'Observaciones'],
                        
                    ]
                ],
            ]);
        ?>
    </div>
   
</div> 
    <div class="form-group" align="center">
    <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Aprobar revisión', ['id'=> 'btAprobarRevision','class' => 'btn btn-success']) ?>
    <?= Html::Button('<span class="glyphicon glyphicon-remove"></span> Rechazar revisión', ['id'=> 'btRechazarRevision', 'class' => 'btn btn-danger']) ?>
<!-- ?= Html::submitButton('Guardar', ['class' => 'btn btn-success','value' => \yii\helpers\Url::to(['asignacion-de-bienes/cambio-usuario']),]) ?> -->
    </div>
<?php ActiveForm::end(); 
$urlRechazarRevision = \yii\helpers\Url::to(['rechazar-revision','id'=>$model->id]);
$urlAprobarRevision = \yii\helpers\Url::to(['aprobar-revision','id'=>$model->id]);
$script = <<< JS

    $("#btAprobarRevision").click(function(){
        if($('#bienuso-tecnico_revision1').val()!='' && $('#bienuso-tecnico_revision2').val()!=''){
            krajeeDialog.confirm("Esta Seguro que quiere aprobar esta revisión?", function (result) {
                if(result){
                    $("#revision_tecnica").attr("action","$urlAprobarRevision").submit();
                }
            });
        }else{
            
            krajeeDialog.alert("DEBE SELECCIONAR LOS TÉCNICOS!");
                return false;
        }
   });

   $("#btRechazarRevision").click(function(){
    
        // if($.trim($("#actarecepcioncabecera").val()) == ""){
        //     krajeeDialog.alert("¡Debe ingresar un motivo de rechazo!");
        //     $("#solicitudcab-motivo_rechazo").val("");
        //     return;
        // }
        if($('#bienuso-tecnico_revision1').val()!='' && $('#bienuso-tecnico_revision2').val()!=''){

            krajeeDialog.confirm("Esta Seguro que quiere rechazar esta revisión?", function (result) {
                if(result){
                    $("#revision_tecnica").attr("action","$urlRechazarRevision").submit();
                }
            });
        }else{
                
                krajeeDialog.alert("DEBE SELECCIONAR LOS TÉCNICOS!");
                    return false;
        }
   });
JS;
$this->registerJs($script);
//yii\widgets\Pjax::end();
?>
