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
use patrimonio\parametros\PatrimonioUsuariosExternos;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AsignacionDeBienes */
/* @var $form yii\widgets\ActiveForm */
//print_r($area);die();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['IN','id_seccion',$areas])->andWhere(['estado'=>'A'])->all();
$externos = patrimonio\parametros\PatrimonioUsuariosExternos::find()->where(['IN','id_dependencia',$idSecciones])->all();
$user = Yii::$app->user->identity->id_agente;
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
  
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 
// print_r($seccion); die();
if (strpos($perfil, 'Administrador')== 1) {
    $disabled=false;
}else{
    $disabled=true;
}
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
                    'columns' => 1,
                    'attributes' => [
                        'id_usuario_bien'=> [
                            'label' => 'Usuario',
                            'id' => 'id_usuario_bien',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                            ] 
                        ],
                        'usuario_externo'=> [
                            'label' => 'Usuarios externos',
                            'id' => 'id_usuario_bien',
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data' => yii\helpers\ArrayHelper::map($externos, 'nombre_usuario', 'nombre_usuario'), 'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione  Nombre y Apellido']
                            ] 
                        ],
                    ]
                ]); 
            ?> 
    </div>
</div> 
    <div class="form-group" align="center">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?> 
<!-- ?= Html::submitButton('Guardar', ['class' => 'btn btn-success','value' => \yii\helpers\Url::to(['asignacion-de-bienes/cambio-usuario']),]) ?> -->
    </div>
<?php ActiveForm::end(); ?>

</div>
