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
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 
if (strpos($perfil, 'Administrador')== 1){
    $disabled = false;
}else{
    $disabled = true;
}

// $usuario= gestion_personal\models\PersonalAgente::find()->where(['id_seccion'=>$area])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=> 'A'])->all();
?>
<div class="evento-createsoli">
<?php $form = ActiveForm::begin(['id' => 'registro_solicitud']);?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            Asignar un nuevo usuario
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'id_encargado'=> [
                            'label' => 'Usuario encargado',
                            'id' => 'id_usuario_bien',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                            ] 
                        ],
                         'id_encargado2'=> [
                            'label' => 'Usuario encargado',
                            //'id' => 'id_usuario_bien',
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
    </div>
</div> 
    <div class="form-group" align="center">
    <?php   if (strpos($perfil, 'Administrador')== 1){ ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success']) ?>
        <?php } ?>

<!-- ?= Html::submitButton('Guardar', ['class' => 'btn btn-success','value' => \yii\helpers\Url::to(['asignacion-de-bienes/cambio-usuario']),]) ?> -->
    </div>
<?php ActiveForm::end(); ?>

</div>
