<?php

use yii\helpers\Html;use patrimonio\models\TrazabilidadBien;
use kartik\widgets\ActiveForm;
use patrimonio\controllers\TrazabilidadBienController;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use parametros\models\ParametrosDelegaciones;
use patrimonio\models\PatrimonioEstadoInterno;
use kartik\datecontrol\DateControl;
use gestion_personal\models\PersonalOrganigrama;
/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm 
 ?>*/
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$bienes= patrimonio\models\BienUso::find()->all();
$Seccion= gestion_personal\models\PersonalOrganigrama::find()->all();
$usuarios= gestion_personal\models\PersonalAgente::find()->all();
?>

<div class="evento-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'id' => 'formprincipal'
    ]);
    ?>

    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
            'id_usuario_solicitante'=> [
                'label' => 'Usuario',
                'id' => 'id_usuario_solicitante',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($usuarios, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                ] 
            ],
            'fecha_carga'=>[
                'label'=>'Fecha de solicitud',
                'type'=>Form::INPUT_WIDGET, 
                'widgetClass'=> kartik\datecontrol\DateControl::class, 
                'options'=>[
                    'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                    'widgetOptions'=>[
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'endDate'=>'now'
                        ],
                    ]
                ]
            ],
            'str_departamento'=> [
            'label' => 'Delegacion',
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'id' => 'id_delegacion',
            'options' => [
                'data'=>yii\helpers\ArrayHelper::map($Seccion, 'id', 'desc_dependencia'),
                'options' => [
                    'placeholder' => 'Seleccione Delegacion',
                ]
            ]
        ],

        
            
        'str_seccion'=> [
            'label' => 'Area',
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'id' => 'str_seccion',
            'options' => [
                'data'=>yii\helpers\ArrayHelper::map($Seccion, 'id', 'desc_desempenio'),
                'options' => [
                    'placeholder' => 'Seleccione Area',
                ]
            ]
        ],
    ]
        ]);
        
    ?> 
            
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'id_estado' => [
                'label' => 'Estado Solicitud',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'Usuario Recepciona',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadosFormularios, 'id','descripcion')],
                ],
                'tipo_solicitud' => [
                    'label' => 'Tipo Solicitud',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'Usuario Recepciona',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($tipoSolicitud, 'id','descripcion')],
                    ]
            ]
        ]);
        ?> 

  
   
    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-10"><span><?= Html::Button('<span class="glyphicon glyphicon-search"></span> Buscar Solicitud', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
        <div class="col-sm-1">
    
        </div>
        <br>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('#btnConsultar').click(function(){
        $('#formprincipal').submit();
            
    });
JS;
$this->registerJs($script);
?>

