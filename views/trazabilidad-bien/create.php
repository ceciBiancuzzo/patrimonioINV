<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrazabilidadBien */

$this->title = 'Create Trazabilidad Bien';
$this->params['breadcrumbs'][] = ['label' => 'Trazabilidad Biens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trazabilidad-bien-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
