<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioEstadoInterno */

$this->title = 'Create Patrimonio Estado Interno';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Estado Internos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-estado-interno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
