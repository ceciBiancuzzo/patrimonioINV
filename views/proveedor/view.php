<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model patrimonio\models\Proveedor */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proveedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proveedor-view">

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
            'id_usuario_modificacion',
            'id_usuario_carga',
            'id_usuario_baja',
            'id_provincia',
            'id_localidad',
            'id_departamento',
            'id',
            'fecha_modificacion',
            'fecha_carga',
            'fecha_baja',
            'fax',
            'email:email',
            'domicilio',
            'denominacion',
            'cuit',
            'condicioniva',
            'telefono',
        ],
    ]) ?>

</div>
