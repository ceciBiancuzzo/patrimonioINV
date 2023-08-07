<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioDependencia */

$this->title = 'Create Patrimonio Dependencia';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Dependencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-dependencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
