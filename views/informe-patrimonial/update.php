<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\InformePatrimonial */

$this->title = 'Update Informe Patrimonial: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informe Patrimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="informe-patrimonial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
