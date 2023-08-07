<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\bootstrap\Modal;
use dosamigos\multiselect\MultiSelectListBox;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;


/* @var $this yii\web\View */
/* @var $model app\models\ActaRecepcionDetalle*/
/* @var $form yii\widgets\ActiveForm */

$delegacion = Yii::$app->user->identity->id_delegacion;
$comision= patrimonio\models\PatrimonioComision::find()->where(['fecha_baja'=>null])->all();
$formaAdquisicion = patrimonio\parametros\PatrimonioFormaAdquisicion::find()->all();
$seccion= patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
//$formaAdquisicion =PatrimonioFormaAdquisicion::findOne($model->id_forma_adquisicion);


    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){             //17 es el numero de la aplicacion de Patrimonio
        $perfil = $perfil . '-' . $roles;
    } 
    $titulo = 'Nueva Acta';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Encargado Recepcion')== 1 ){
  ?>

<div class="well" align='center'>
    <div class='panel panel-primary'>
        <h4>Nueva Acta de Recepcion </h4>
    </div>

    <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-primary" style="width:100%" >
            <div class="panel-heading">
                <h3 class="panel-title" align='center'>
                <i class="glyphicon glyphicon-pencil"></i>
                DATOS DE ACTA DE RECEPCION </h3>
            </div>
        <div class="panel-body">
            <div class="row">
            </div>
                <?=
                    Form::widget([
                        'model'=> $model,
                        'form'=> $form,
                        'columns'=> 3,                            
                        'attributes' => [
                            'id_dependencia'=> [
                                'label' => 'Area Adquirente',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'id' => 'id_dependencia',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($seccion, 'id', 'strDependencia'),'pluginOptions' => ['allowClear' => true],
                                    'options' => [
                                        'placeholder' => 'Seleccione área adquirente',
                                    ]
                                ]
                            ],
                            'fecha_acta'=>[
                                'label'=>'Fecha de operación',
                                'type'=>Form::INPUT_WIDGET, 
                                'widgetClass'=> kartik\datecontrol\DateControl::class, 
                                'options'=>[
                                    'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                                    'widgetOptions'=>[
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                            'endDate'=>'now',
                                         
                                        ],
                                    ]
                                ]
                            ],

                            'nro_expediente'=> [
                                'label' => 'Numero de Expediente',
                                'type' => Form::INPUT_TEXT,
                                'options' => [
                                    'placeholder'=> 'Ingrese numero de expediente',
                                ]
                            ],
                        ],
                    ])
                ?> 
                 <?=
                    Form::widget([
                        'model'=> $model,
                        'form'=> $form,
                        'columns'=> 3,                            
                        'attributes' => [
                            'id_forma_adquisicion' => [
                                'label' => 'Forma de Adquisicion',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($formaAdquisicion, 'id', 'denominacion'),'pluginOptions' => ['allowClear' => true],
                                    'options' => [
                                        'placeholder' => 'Seleccione Forma de Adquisicion',
                                    ]
                                ]
                            ],
                            'orden_compra'=> [
                                'label' => 'Orden de compra',
                                'type' => FORM::INPUT_TEXT,
                                'options' => [
                                    'placeholder' => 'Ingrese orden de compra',
                                ]
                            ],
                            'id_comision' => [
                                'label' => 'Comisión',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($comision, 'id', 'strComision'),'pluginOptions' => ['allowClear' => true],
                                    'options' => [
                                        'placeholder' => 'Seleccione la comisión',
                                    ]
                                ]
                            ],
                            
                        ]
                    ])
                ?> 
                <?=
                    Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 'autoGenerateColumns',
                        'attributes' => [
                            'texto_acta'=> [
                                'label' => 'Texto de conformidad',
                                'type' => Form::INPUT_TEXTAREA,
                                'options' => [
                                    'placeholder'=> '',
                                    'rows' => '5',
                                    'value'=>
                                    'Los que suscriben, reunidos en comisión, dentro de las facultades que determinan las reglamentaciones vigentes y acotando la responsabilidad a las limitaciones técnicas que a cada uno de ellos pudiera alcanzar en razón de la especificidad, cualidades o particularidades que el objeto de la presente contratación tiene, proceden a formalizar la recepción definitiva de los elementos,  mercaderías o servicios abajo detallados, comprobando que los mismos se ajustan a las especificaciones contratadas, considerando el informe técnico que se menciona en la presente.'
                                ]       
                            ]
                        ]
                    ]);
                ?> 
            </div>
            <div class="form-group" align='center'>
                <?php 
                    $urlRegresar = "acta-recepcion-cabecera/index";
                    echo Html::a('<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id'=> 'btRegresar', 'class'=> 'btn btn-primary']);
                ?>
                <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Crear Acta', ['id' =>'btnCrearActa','class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <?php } ?>
</div>
