<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model patrimonio\parametros\PatrimonioRubro */

$this->title = 'Create Patrimonio Rubro';
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Rubros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patrimonio-rubro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
