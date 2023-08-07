<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model espumante\models\EspumanteMovimientosInternosDet */
/* @var $form ActiveForm */

//print_r($model->envase->descripcion);
//busco la cabecera para analizar el estado del producto, si este es estado presentado (1) ahi solamente calculo el saldo
$modelCab = \aprobacion_ddjj\models\EspumanteMovimientosInternosCab::findOne($model->id_cab);


$saldoReal = 0;
$saldoComprometido = 0;
$totalParcial = 0;
$total = 0;
$volumen = 0;


if ($modelCab->idestado == 1) {
    if ($model->disminucion_aumento == 'D') {
        $volumen = $total - $model->volumen;
    } else {
        $volumen = $total + $model->volumen;
    }
}
?>
<div class="form_existencia_det" >
    <?php $form = ActiveForm::begin(['id' => 'existencia-det-form-id']); ?>
    
    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'disminucion_aumento' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->disminucion_aumento == 'A' ? 'AUMENTO' : 'DISMINUCION', 'disabled' => true,]],
            'id_producto' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->producto->codigo_producto . ' - ' . $model->producto->descripcion_producto, 'disabled' => true,]],
        ],
    ]);
    ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_variedad1' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->id_variedad1 <> null ? $model->variedad1->codigo_variedad . '-' . $model->variedad1->nombre_variedad : '',
                    'disabled' => true,]],
            'id_variedad2' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->id_variedad2 <> null ? $model->variedad2->codigo_variedad . '-' . $model->variedad2->nombre_variedad : '',
                    'disabled' => true,]],
            'id_variedad3' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->id_variedad3 <> null ? $model->variedad3->codigo_variedad . '-' . $model->variedad3->nombre_variedad : '',
                    'disabled' => true,]],
        ]
    ]);
    ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
            'id_procedencia_elaboracion' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->procedenciaElaboracion->descripcion_procedencia, 'disabled' => true,]],
            'propiedad' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->propiedad == 1 ? 'PROPIO' : 'TERCEROS', 'disabled' => true,]],
            'id_estado_producto' => ['label' => 'Estado del Producto', 'type' => Form::INPUT_TEXT, 'options' => ['value' => $model->estadoProducto->descripcion_estado_producto, 'disabled' => true,]],
            'nro_gde' => ['label' => 'Nro. GDE / Tramite', 'type' => Form::INPUT_TEXT, 'options' => ['disabled' => true]],
        ]
    ]);
    ?>  
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'ano_elaboracion' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
            'id_frigorifico' => ['label' => 'Inscripto Frigorifico', 'type' => Form::INPUT_TEXT, 'options' => ['disabled' => true]],
        ]
    ]);
    ?>       
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
            'volumen' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
            'grado_alcohol' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
            'grado_absoluto' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
        ]
    ]);
    ?>    
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_envase' => ['label' => 'Envase', 'type' => Form::INPUT_TEXT, 'options' => ['value' => $model->envase->descripcion, 'disabled' => true,]],
            'cantidad_envase' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
            'capacidad_envase' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
        ]
    ]);
    ?>    
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_tipoanalisis' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'value' => $model->id_tipoanalisis == null ? 'SIN ANALIZAR' : $model->tipoAnalisis->descripcion_tipo_analisis,
                    'disabled' => true,]],
            'nro_analisis' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
            'cade' => ['label' => 'CUDE', 'type' => Form::INPUT_TEXT, 'options' => ['disabled' => true,]],
        ]
    ]);
    ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'estado_produccion' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => ($model->estado_produccion == 1) ? 'ELABORACION' : 'TERMINADO', 'disabled' => true,]],
            'sistema_elaboracion' => ['label' => 'Sistema de Elaboracion', 'type' => Form::INPUT_TEXT, 'options' => ['value' => $model->sistemaElaboracion->descripcion_sistema_elaboracion, 'disabled' => true,]],
            'fecha_inicio_elaboracion' => ['label' => 'Fecha Inicio de Elaboracion', 'type' => Form::INPUT_TEXT, 'options' => ['value' => $model->fecha_inicio_elaboracion, 'disabled' => true,]],
        ]
    ]);
    ?>
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'id_tipodg' => ['type' => Form::INPUT_TEXT, 'options' => ['value' => $model->tipoIg->descripcion_ig, 'disabled' => true,]],
            'ig_dg_zonas' => ['label' => 'Zona DG', 'type' => Form::INPUT_TEXT, 'options' => ['value' => $model->zonaDg->denominacion_geografica, 'disabled' => true,]],
        ]
    ]);
    ?>    

    <?php ActiveForm::end(); ?>

    <?php
    $script = <<< JS
$(document).ready(function() {
        saldo = document.getElementById('espumantemovimientosinternosdet-saldo').value;  
        saldoproyectado = document.getElementById('espumantemovimientosinternosdet-saldoproyectado').value;  
            if(saldo >= 0){
               document.getElementById('espumantemovimientosinternosdet-saldo').style.color = "green";
            }else{
              document.getElementById('espumantemovimientosinternosdet-saldo').style.color = "red";
            }
        if(saldoproyectado >= 0){
               document.getElementById('espumantemovimientosinternosdet-saldoproyectado').style.color = "green";
            }else{
              document.getElementById('espumantemovimientosinternosdet-saldoproyectado').style.color = "red";
            }
    });   
JS;
    $this->registerJs($script);
    ?>
</div><!-- form_existencia_det -->
