<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\AsignacionDeBienes */

$this->title = 'Create Asignacion De Bienes';
$this->params['breadcrumbs'][] = ['label' => 'Asignacion De Bienes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignacion-de-bienes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
