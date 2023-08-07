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

/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm */

$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$anios = [];
for ($i = 2017; $i <= date('Y'); $i++) {
    $anios[$i] = ['id' => $i, 'ano' => $i];
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
            'id_delegacion' => [
                'label' => 'Delegacion',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'id_delegacion',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($delegaciones,'id','descripcion_delegacion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione Delegacion',]
                ],
            ],
            'anoinv' => [
                'label' => 'Año',
                'id' => 'anoInv',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($anios, 'id', 'ano'),
                    'pluginOptions' => ['allowClear' => true], 
                    'options' => ['placeholder' => 'Seleccione Año', 'value' => date('Y')]],
            ],
        ]
    ]);
    ?> 
    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_condicion' => [
                'label' => 'Condicion del bien',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($condicionBien, 'id', 'descripcion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => [
                        'placeholder' => 'Seleccione Condicion del bien',
                    ]
                ],
            ],
            'fecha_acta' => [
                'label' => 'Fecha de Acta',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => kartik\date\DatePicker::classname(),
                'useWithAddon' => true,
                'convertFormat' => true,
                'options' => ['pluginOptions' => [
                        'locale' => [
                            'format' => 'DD/MM/YYYY',
                            'separator' => ' a '
                        ]
                    ]]
            ],
            'orden_compra' => [
                'label' => 'Orden de Compra',
                'type' => Form::INPUT_TEXT,
                'options' => ['placeholder' => 'Ingrese orden de compra',]
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
        <div class="col-sm-10"><span><?= Html::Button('Consultar', ['id' => 'btnConsultar', 'class' => 'btn btn-primary']) ?></span></div>
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
     
            if($('#acta-recepcion-cabecera-anoinv').val()==''
                && $('#acta-recepcion-cabecera-id_delegacion').val()==''
                && $('#acta-recepcion-cabecera-orden_compra').val()==''){
                //&& $('#espumantemovimientosinternoscabsearch-id_tipo_movimiento').val()==''
                //&& $('#espumantemovimientosinternoscabsearch-id_nroins').val()==''){
        
                krajeeDialog.alert("Por favor seleccione al menos un filtro para realizar la búsqueda.");
                return false;
        
            }else{
        
                $('#formprincipal').submit();
        
            }
    });
JS;

$this->registerJs($script);
?>

