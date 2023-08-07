<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActaTransferenciaDet */

$this->title = 'Create Acta Transferencia Det';
$this->params['breadcrumbs'][] = ['label' => 'Acta Transferencia Dets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acta-transferencia-det-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
