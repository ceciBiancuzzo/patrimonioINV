<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\Amortizacion */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Amortizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="amortizacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
