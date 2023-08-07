<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActaRecepcionCabecera */

$this->params['breadcrumbs'][] = ['label' => 'Acta Recepcion Cabecera', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acta-recepcion-cabecera-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
