<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudCab */

$this->title = 'Crear Solicitud';
$this->params['breadcrumbs'][] = ['label' => 'Solicitud', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-cab-create">

    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Crear Solicitud</h4>
        </div>    
        <?php echo $this->render('_form', ['model' => $model]); ?>    
    </div>
</div>
