<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use common\models\AccessHelpers;
use parametros\models\ParametrosDelegaciones;
use gestion_personal\models\PersonalOrganigrama;

/* patrimonio\views\trazabilidad_bien */

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */

$estadoBien = patrimonio\parametros\PatrimonioEstadoInterno::find()->where(['fecha_baja' => null])->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$estadoFormulario= patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$agente= gestion_personal\models\PersonalAgente::find()->all();
$area= gestion_personal\models\PersonalOrganigrama::find()->all();
$seccion = patrimonio\parametros\PatrimonioDependencia::find()->all();
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
        'columns' => 2,
        'attributes' => [

           
            
                
        'id_dependencia'=> [
            'label' => 'Seccion Transfiere',
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'id' => 'str_seccion',
            'options' => [
                'data'=>yii\helpers\ArrayHelper::map($seccion, 'id', 'denominacion'),
                'pluginOptions' => ['allowClear' => true],
                'options' => [
                    'placeholder' => 'Seleccione Seccion',
                ]
            ]
        ],

        'id_dependencia2'=> [
            'label' => 'Seccion Recepciona',
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'id' => 'str_seccion',
            'options' => [
                'data'=>yii\helpers\ArrayHelper::map($seccion, 'id', 'denominacion'),
                'pluginOptions' => ['allowClear' => true],
                'options' => [
                    'placeholder' => 'Seleccione Seccion',
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

     
            'tipo_solicitud' => [
                'label' => 'Tipo Solicitud',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'Usuario Recepciona',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($tipoSolicitud, 'id','descripcion'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione Tipo de Solicitud']
                   
                  
               
                ],
                
                
                    ]
            
                
        
      
        ]
          
           
         
        
    ]);
    ?> 

<?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
          
            'fecha_transferencia' => [
                'label' => 'Fecha de Transferencia',
                'type' => Form::INPUT_WIDGET,
                    'widgetClass' => kartik\datecontrol\DateControl::classname(),
                    'useWithAddon' => true,
                    'convertFormat' => true,
                    'options' => ['pluginOptions' => [
                            'locale' => [
                                'format' => 'DD/MM/YYYY',
                                'separator' => ' a '
                            ]
                        ]
                    ]
            ],


            'nro_acta_transferencia' => [
                'label' => 'Número acta transferencia',
                'type' => Form::INPUT_TEXT,
               
                'id' => 'nro_acta_tranferencia',
                'options' => [
                
                ],
            ],
            'id_estado_formulario' => [
                'label' => 'Estado Transferencia',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'id_estado_formulario',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadoFormulario, 'id', 'descripcion'), 
                     'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione Estado']
                ],
            ],
          
           
        ]
    ]);
    ?> 
  
    <?php
    if (AccessHelpers::getAcceso('delegaciones', Yii::$app->controller->id)) {
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                 'id_delegacion' => [
                     'label' => 'Delegación',
                     'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                     'options' => [
                         'data' => yii\helpers\ArrayHelper::map(ParametrosDelegaciones::find()->where(['aud_fecbaja' => null])->andWhere(['NOT IN', 'codigo_delegacion', [93, 0, 999, 50, 233]])->all(), 'id', 'descripcion_delegacion'), 'pluginOptions' => ['allowClear' => true],
                        'options' => [
                        'placeholder' => 'Seleccione una Delegación',
                        ]
                    ]
                 ]
            ]
        ]);
    }
    ?>
    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-sm-10"><span><?= Html::Button('<span class="glyphicon glyphicon-search"></span> Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
        <div class="col-sm-1">
        <?php
            echo Html::a(
                    '<span class="glyphicon glyphicon-question-sign"></span>', '@web/pdf/Manual-de-Usuario-Sistema-Patrimonio.pdf', [
                'class' => 'btn btn-primary',
                'title' => '¿Necesitas ayuda?',
                'target' => '_blank',
                'data-toggle' => 'tooltip'
                    ]
            );
            ?>
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
