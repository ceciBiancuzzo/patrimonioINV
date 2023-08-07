<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioEncargadoPatrimonial */

$this->title = 'Create Patrimonio Encargado Patrimonial';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Encargado Patrimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-encargado-patrimonial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
