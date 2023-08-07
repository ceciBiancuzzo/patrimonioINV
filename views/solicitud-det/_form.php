<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-det-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones')->textInput() ?>

    <?= $form->field($model, 'cantidad_solicitada')->textInput() ?>

    <?= $form->field($model, 'cantidad_autorizada')->textInput() ?>

    <?= $form->field($model, 'saldo_entrega')->textInput() ?>

    <?= $form->field($model, 'fecha_carga')->textInput() ?>

    <?= $form->field($model, 'fecha_baja')->textInput() ?>

    <?= $form->field($model, 'fecha_modificacion')->textInput() ?>

    <?= $form->field($model, 'id_usuario_carga')->textInput() ?>

    <?= $form->field($model, 'id_usuario_modificacion')->textInput() ?>

    <?= $form->field($model, 'id_usuario_baja')->textInput() ?>

    <?= $form->field($model, 'id_solicitud_cab')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
