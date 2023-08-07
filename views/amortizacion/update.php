<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\Amortizacion */

$this->title = 'Update Amortizacion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Amortizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="amortizacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
