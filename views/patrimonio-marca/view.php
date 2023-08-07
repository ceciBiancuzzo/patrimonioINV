<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActaTransferenciaDet */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acta Transferencia Dets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acta-transferencia-det-view">

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
            'id_bien_uso',
            'observaciones',
            'fecha_carga',
            'fecha_baja',
            'fecha_modificacion',
            'id_usuario_carga',
            'id_usuario_baja',
            'id_usuario_modificacion',
            'id_condicion',
            'necesidad_aprobacion:boolean',
            'id_agente_tecnico',
            'id_agente_patrimonio',
            'aprobacion_tecnico:boolean',
        ],
    ]) ?>

</div>
