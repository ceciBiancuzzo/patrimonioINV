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
use patrimonio\models\PatrimonioEstadoInterno;

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */

$estadosFormulario = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$tiposMovimientos = common\models\parametros\ParametrosTipoMovimientos::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$seccion =patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
$bienes= patrimonio\models\BienUso::find()->all();

$anios = [];
for ($i = 1962; $i <= date('Y'); $i++) {
    $anios[$i] = ['id' => $i, 'ano' => $i];
}

$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
        foreach ($busco_perfiles[17] as $roles){             //17 es el numero de la aplicacion de Patrimonio
    $perfil = $perfil . '-' . $roles;
} 
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
            'id_bien_uso' => [
                'label' => 'Estado interno',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'idestado',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadosFormulario, 'id', 'descripcion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione un estado',]
                    
                ],
            ],
            'id' => ['label' => 'Area', 'type' => Form::INPUT_WIDGET, 
            'widgetClass' => '\kartik\widgets\Select2',
            'options' => [
               'data'=>yii\helpers\ArrayHelper::map($seccion,'id','strDependencia'),'pluginOptions' => ['allowClear' => true],
               'options' => [
                'placeholder' => 'Seleccione un área',
            ]
            ]],
            
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
                    '<span class="glyphicon glyphicon-question-sign"></span>', '@web/pdf/MovimientoInterno_gestion.pdf', [
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
     
            if($('#espumantemovimientosinternoscabsearch-anoinv').val()==''
                && $('#espumantemovimientosinternoscabsearch-tipo_alta').val()==''
                && $('#espumantemovimientosinternoscabsearch-idestado').val()==''
                && $('#espumantemovimientosinternoscabsearch-id_tipo_movimiento').val()==''
                && $('#espumantemovimientosinternoscabsearch-id_nroins').val()==''){
        
                krajeeDialog.alert("Por favor seleccione al menos un filtro para realizar la búsqueda.");
                return false;
        
            }else{
        
                $('#formprincipal').submit();
        
            }
    });
JS;

$this->registerJs($script);
?>
