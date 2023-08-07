<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\PatrimonioComision */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patrimonio Comisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="patrimonio-comision-view">

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
            'denominacion',
            'anio',
            'persona1',
            'persona2',
            'persona3',
            'persona4',
            'persona5',
            'persona6',
            'activa:boolean',
            'fecha_carga',
            'fecha_modificacion',
            'fecha_baja',
            'id_usuario_carga',
            'id_usuario_modificacion',
            'id_usuario_baja',
        ],
    ]) ?>

</div>
