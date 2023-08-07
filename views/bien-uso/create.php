<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BienUso */

$this->title = 'Crear Bien Uso';
$this->params['breadcrumbs'][] = ['label' => 'Bien Usos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bien-uso-create">
<br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Alta Bien</h4>
        </div>    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>