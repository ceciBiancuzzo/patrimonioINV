<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioCondicionBien */

$this->title = 'Create Patrimonio Condicion Bien';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Condicion Biens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-condicion-bien-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
