<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\dialog\Dialog;
use kartik\popover\PopoverX;
use kartik\builder\FormGrid;
use yii\helpers\Url;
use kartik\bs5dropdown\ButtonDropdown;
use patrimonio\parametros\PatrimonioMarca;

$marcas= patrimonio\parametros\PatrimonioMarca::find()->where(['fecha_baja' => null]) ->orderBy(['id' => SORT_DESC])->all();
// $partida = patrimonio\parametros\PatrimonioPartida::find()->all();
$rubro = patrimonio\parametros\PatrimonioRubro::find()->where(['fecha_baja' => null])->all();
$estados= patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$condiciones = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$seccion = gestion_personal\models\PersonalOrganigrama::find()->all();
$dependencias = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Alerta',
    ]
]);
// print_r($modelMarca);
// die();
$titulo = 'Registro del bien';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'registro_bien']); ?> 
<div class="well" align='center'>
    <div class="panel panel-primary">
        <h4>Nuevo registro de bien</h4>
    </div>
<div class="evento-createbien">

<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

 <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            DATOS REGISTRO PROVISORIO
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
                <?=
                 FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [ 
                                'id_rubro' => ['label' => 'Rubro', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($rubro,'id', 'strRubro'),
                                'options' => ['placeholder' => 'Seleccione el rubro'], 
                                ]],         
                                 
                                'id_dependencia' => ['label' => 'Dependencia', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($dependencias,'id','strDependencia'),
                                   'options' => ['placeholder' => '-'], 
                                   'disabled' => false, 
                                ]],
                            
                            ]]]])
                            ?>         
                            <?=
                              FormGrid::widget([
                                'model' => $model,
                                'form' => $form,
                                'autoGenerateColumns' => 3,
                                'rows' => [
                                    [
                                        'attributes' => [ 
                              'id_estado_interno' => ['label' => 'Estado interno ', 'type' => Form::INPUT_WIDGET, 
                              'widgetClass' => '\kartik\widgets\Select2',
                              'options' => [
                              'data'=>yii\helpers\ArrayHelper::map($estados,'id','denominacion'),
                              'options' => ['disabled' => true,'placeholder'=>'Provisorio'], 
                              ]],
                              'id_condicion' => ['label' => 'Condición del bien', 'type' => Form::INPUT_WIDGET, 
                              'widgetClass' => '\kartik\widgets\Select2',
                              'options' => [
                              'data'=>yii\helpers\ArrayHelper::map($condiciones,'id','descripcion'),
                              'options' => ['disabled' => true,'value'=>1], 
                              ]],
                              
                    ]
                        ]
                ]]);
                ?>
            </div>
        </div>

        <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            DATOS GENERALES DEL BIEN
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
                <?=  
                    FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                     
                            'modelo' => ['type' => Form::INPUT_TEXT],
                            'id_marca' => ['label' => 'Marca ', 'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                            'data'=>yii\helpers\ArrayHelper::map($marcas,'id','denominacion'),
                            'options' => ['placeholder' => 'Seleccione la marca'], 
                        ]
                            ],         
                            
                            'precio_origen'=> [
                                'label' => 'Valor de origen',
                                'type' => Form::INPUT_TEXT,
                                // 'options' => ['readOnly' => true]
                                
                            ],
                           
                        ],
                    ]
                ]]);
                //Redirige al form marca para poder agregar la marca con el popover
                echo $this->context->renderPartial('_form_marca');
                ?>
            </div>           
</div>
<div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            OTROS DATOS
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
                <?= FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                'descripcion_bien' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Descripción del bien', 'options' => ['placeholder' => '']],
                                'tipo_bien'=> ['type'=>Form::INPUT_TEXTAREA],
                                'cantidad'=> ['type'=>Form::INPUT_TEXT],
                            ]
                        ],
                    ]
                ]);
                ?>
    
    </div>
</div>

<div class="form-group" align="center">
    <?php
$urlRegresar = "bien-uso/index";
     echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-info']); 
    ?>
    <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary']);?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
//$url = Url::to(['cosecha-autoriza-ciu-cab/datos-inscripto']);
$script = <<< JS
  $('#btnMarca').click(function(){
      alert(objdata)
  })
    
    // $('#btnGuardar').click(function(){
    //     console.log("aca");
        
    //     $('#registro_bien').submit();
    //     console.log("hola");
    // //  });    
    //  $("form#registro_bien").on("beforeSubmit",function(e){
    //      console.log("a");
    //     var form = $(this);
    //     $.post(
    //         form.attr("action")+"&submit=true",
    //         form.serialize()
    //     )
    // });
JS;
$this->registerJs($script);
//yii\widgets\Pjax::end();
?>