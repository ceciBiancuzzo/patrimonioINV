<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Dets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="solicitud-det-view">

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
            'descripcion',
            'cantidad',
            'observaciones',
            'cantidad_solicitada',
            'cantidad_autorizada',
            'saldo_entrega',
            'fecha_carga',
            'fecha_baja',
            'fecha_modificacion',
            'id_usuario_carga',
            'id_usuario_modificacion',
            'id_usuario_baja',
            'id_solicitud_cab',
        ],
    ]) ?>

</div>
