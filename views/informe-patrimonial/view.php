<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\InformePatrimonial */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informe Patrimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="informe-patrimonial-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'observaciones',
            'id_usuario_aprobacion',
            'fecha_aprobacion',
            'fecha_presentacion',
            'fecha_carga',
            'fecha_baja',
            'fecha_modificacion',
            'id_bien_uso',
        ],
    ]) ?>

</div>
