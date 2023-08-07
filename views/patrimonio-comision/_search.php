<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\search\PatrimonioComisionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-comision-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'denominacion') ?>

    <?= $form->field($model, 'anio') ?>

    <?= $form->field($model, 'persona1') ?>

    <?= $form->field($model, 'persona2') ?>

    <?php // echo $form->field($model, 'persona3') ?>

    <?php // echo $form->field($model, 'persona4') ?>

    <?php // echo $form->field($model, 'persona5') ?>

    <?php // echo $form->field($model, 'persona6') ?>

    <?php // echo $form->field($model, 'activa')->checkbox() ?>

    <?php // echo $form->field($model, 'fecha_carga') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'fecha_baja') ?>

    <?php // echo $form->field($model, 'id_usuario_carga') ?>

    <?php // echo $form->field($model, 'id_usuario_modificacion') ?>

    <?php // echo $form->field($model, 'id_usuario_baja') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
