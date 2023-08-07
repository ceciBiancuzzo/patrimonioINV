<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PatrimonioCondicionBienSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-condicion-bien-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'fecha_carga') ?>

    <?= $form->field($model, 'fecha_baja') ?>

    <?= $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'id_usuario_carga') ?>

    <?php // echo $form->field($model, 'id_usuario_modificacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
