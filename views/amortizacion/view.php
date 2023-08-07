<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\Amortizacion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Amortizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="amortizacion-view">

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
            'amortizacion_anual',
            'amortizacion_anual_acumulada',
            'valor_residual',
            'anio',
            'r_431',
            'r_432',
            'r_433',
            'r_434',
            'r_435',
            'r_436',
            'r_437',
            'r_438',
            'r_439',
            'fecha_carga',
            'fecha_modificacion',
            'fecha_baja',
            'id_usuario_carga',
            'id_usuario_modificacion',
            'id_usuario_baja',
        ],
    ]) ?>

</div>
