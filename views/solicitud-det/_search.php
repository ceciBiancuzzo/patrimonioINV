<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use parametros\models\ParametrosDelegaciones;
use patrimonio\models\PatrimonioEstadoInterno;

/* @var $this yii\web\View */
/* @var $model app\models\search\SolicitudDetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-det-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'observaciones') ?>

    <?= $form->field($model, 'cantidad_solicitada') ?>

    <?php // echo $form->field($model, 'cantidad_autorizada') ?>

    <?php // echo $form->field($model, 'saldo_entrega') ?>

    <?php // echo $form->field($model, 'fecha_carga') ?>

    <?php // echo $form->field($model, 'fecha_baja') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'id_usuario_carga') ?>

    <?php // echo $form->field($model, 'id_usuario_modificacion') ?>

    <?php // echo $form->field($model, 'id_usuario_baja') ?>

    <?php // echo $form->field($model, 'id_solicitud_cab') ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
