<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use kartik\datecontrol\DateControl;
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

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AmortizacionAnualCab */
/* @var $form yii\widgets\ActiveForm */
$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
?>

<div class="amortizacion-anual-cab-form">

    <?php $form = ActiveForm::begin(['id' => 'registro_amortizacion']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
Proveedores
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
            <div
         </div>   
         <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                    
                        'denominacion'=> [
                            'label' => 'Denominacion',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'ingrese Proveedor',
                            ]
                        ],
                        'fax'=> [
                            'label' => 'Fax',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Infrese fax',
                            ]
                        ],
                        'email'=> [
                            'label' => 'Email',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese el email',
                            ]
                        ],
                    ]
                ]);
                ?> 
                <?=
                Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                    
                        'domicilio'=> [
                            'label' => 'Domicilio',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese domicilio',
                            ]
                        ],
                        'cuit'=> [
                            'label' => 'Cuit',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Infrese CUIT',
                            ]
                        ],
                        'telefono'=> [
                            'label' => 'Telefono',
                            'type' => Form::INPUT_TEXT,
                            'options' => [
                                'placeholder' => 'Ingrese el telefono',
                            ]
                        ],
                    ]
                ]);
                ?> 
 

    <div class="form-group">
    <?php   if (strpos($perfil, 'Administrador')== 1){ ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
