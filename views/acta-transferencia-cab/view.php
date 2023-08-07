<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActaTransferenciaCab */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acta Transferencia Cabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acta-transferencia-cab-view">

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
            'id_area_transferencia',
            'id_area_recepcion',
            'id_usuario_transferencia',
            'id_usuario_recepcion',
            'fecha_recepcion',
            'fecha_transferencia',
            'observaciones',
            'fecha_carga',
            'fecha_baja',
            'fecha_modificacion',
            'id_usuario_carga',
            'id_usuario_baja',
            'id_usuario_modificacion',
            'nro_acta_transferencia',
        ],
    ]) ?>

</div>
