<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\PatrimonioComision */

$this->title = 'Create Patrimonio Comision';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Comisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-comision-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
