<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SolicitudDetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitud Dets';
$this->params['breadcrumbs'][] = $this->title;
$bienes= patrimonio\models\BienUso::find()->all();
?>
<div class="solicitud-det-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Solicitud Det', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'descripcion',
            'cantidad',
            'observaciones',
            'cantidad_solicitada',
            //'cantidad_autorizada',
            //'saldo_entrega',
            //'fecha_carga',
            //'fecha_baja',
            //'fecha_modificacion',
            //'id_usuario_carga',
            //'id_usuario_modificacion',
            //'id_usuario_baja',
            //'id_solicitud_cab',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
