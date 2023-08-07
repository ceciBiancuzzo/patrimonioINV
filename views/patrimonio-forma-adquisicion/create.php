<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioFormaAdquisicion */

$this->title = 'Create Patrimonio Forma Adquisicion';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Forma Adquisicions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-forma-adquisicion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
