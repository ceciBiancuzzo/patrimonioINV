<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\InformePatrimonial */

$this->title = 'Create Informe Patrimonial';
$this->params['breadcrumbs'][] = ['label' => 'Informe Patrimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informe-patrimonial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
