<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use yii\helpers\Url;
use patrimonio\parametros\Proveedor;
use patrimonio\models\ActaRecepcionCabecera;

/* @var $this yii\web\View */
/* @var $model espumante\models\EspumanteMovimientosInternosDet */
/* @var $form ActiveForm */
$cab = ActaRecepcionCabecera::find()
->where(['id'=>$model->id_cab])
->one();


$tecnico= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$BiendeUso = patrimonio\models\BienUso::find()->where(['id_estado_interno'=>1])->andWhere(['id_acta_recepcion_definitiva'=>null])->andWhere(['fecha_baja' =>null])->all();
$proveedor = patrimonio\parametros\Proveedor::find()->all();
$area = patrimonio\parametros\PatrimonioDependencia::find()->all();

$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){      
        $perfil = $perfil . '-' . $roles;
    } 


echo \kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
]);

?>
    <div class="form_autoriza_det_recepcion" >
        <?php $form = ActiveForm::begin(['id'=>'registro-detalle']); ?>
        <!-- campos ocultos -->
        <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'id_cab')->hiddenInput()->label(false); ?>
        <div>
        <?php 
         if(strpos($perfil, 'Administrador') == 1 || strpos($perfil, 'Agente')==1 || strpos($perfil, 'Jefe' ) == 1){ ?>
        <?= Form::widget([    
                'model'=>$model,
                'form'=>$form,
                'columns'=>2,
                'attributes'=>[ 
                    
                    'id_bien_uso' => [
                        'label' => 'Bien de Uso',
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\Select2',
                        'id' => 'id_bien_uso',
                        'options' => [
                            'data' => yii\helpers\ArrayHelper::map($BiendeUso, 'id', 'strBien'), 'pluginOptions' => ['allowClear' => true],
                            'options' => ['placeholder' => 'Seleccione Bien de Uso',]
                        ],
                    ],
                    'cantidad' => [
                        'label' => 'Cantidad',
                        'type' => Form::INPUT_TEXT,
                        'id' => 'cantidad',
                        'options' => [
                            'placeholder' => 'Ingrese cantidad'
                        ]
                    ],
                    'id_proveedor' => [
                        'label' => 'Proveedor',
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\Select2',
                        'id' => 'id_proveedor',
                        'options' => [
                            'data' => yii\helpers\ArrayHelper::map($proveedor, 'id', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                            'options' => ['placeholder' => 'Seleccione Proveedor',]
                        ]
                    ],
                    'garantia' => [
                        'label' => 'Garantia',
                        'type' => Form::INPUT_TEXT,
                        'id' => 'garantia',
                        'options' => [
                            'placeholder' => 'Ingrese periodo de garantia',
                        ]
                        ],
                        'renglon' => [
                            'label' => 'Renglon',
                            'type' => Form::INPUT_TEXT,
                            'id' => 'garantia',
                            'options' => [
                                'placeholder' => 'Ingrese renglon',
                            ]
                        ]        
                    ],
                ]);
            
            echo $this->context->renderPartial('_form_proveedor');

            ?>
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'necesidad_aprobacion' => [
                    'label' => '¿Requiere aprobacion de un tecnico?',
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => [true => 'Si', false => 'No'],
                    'options' => ['inline' => true, 'default' => 'No']
                ],
                'tecnico_externo' => [
                    'label' => '¿Es un tecnico externo?',
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => [true => 'No', false => 'Si'],
                    'options' => ['inline' => true, 'default' => 'No']
                ],
            ]
        ])
        ?>
    
        <div id="aprobacion_tecnico">
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'id_area_tecnica' => [
                    'label' => 'Area técnica',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'id' => 'id_agente_tecnico',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($area, 'id','strDependencia'),
                        'options' => ['placeholder' => 'Seleccione Tecnico'],
                    ]
                ],

            ]
        ]);
        ?>
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'comentario' => [
                    'label' => 'Comentario',
                    'type' => Form::INPUT_TEXTAREA,
                    'id' => 'comentario',
                    'options' => ['style' => 'text-align: center'],
                ]
            ]
            ])
            ?>
            <?php } ?>

        <?php 
        if (strpos($perfil, 'Encargado') ==1 || strpos($perfil, 'Jefe') ==1  ){
        ?>
        <?= Form::widget([    
                'model'=>$model,
                'form'=>$form,
                'columns'=>2,
                'attributes'=>[ 
                    
                    'id_bien_uso' => [
                        'label' => 'Bien de Uso',
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\Select2',
                        'id' => 'id_bien_uso',
                        'options' => [
                            'data' => yii\helpers\ArrayHelper::map($BiendeUso, 'id', 'strBien'), 'pluginOptions' => ['allowClear' => true],
                            'options' => ['placeholder' => 'Seleccione Bien de Uso'],
                            'disabled' => true
                        ],
                    ],
                    'cantidad' => [
                        'label' => 'Cantidad',
                        'type' => Form::INPUT_TEXT,
                        'id' => 'cantidad',
                        'options' => [
                            'placeholder' => 'Ingrese cantidad',
                            'disabled' => true
                        ]
                    ],
                    'id_proveedor' => [
                        'label' => 'Proveedor',
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\Select2',
                        'id' => 'id_proveedor',
                        'options' => [
                            'data' => yii\helpers\ArrayHelper::map($proveedor, 'id', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                            'options' => ['placeholder' => 'Seleccione Proveedor',],
                            'disabled' => true
                        ]
                    ],
                    'garantia' => [
                        'label' => 'Garantia',
                        'type' => Form::INPUT_TEXT,
                        'id' => 'garantia',
                        'options' => [
                            'placeholder' => 'Ingrese periodo de garantia',
                            'disabled' => true
                        ]
                        ],
                    ],
                ]);
            ?>
        
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'necesidad_aprobacion' => [
                    'label' => '¿Requiere aprobacion de un tecnico?',
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => [true => 'Si', false => 'No'],
                    'options' => ['inline' => true, 'default' => 'No',
                    'disabled' => true]
                ],
                'tecnico_externo' => [
                    'label' => '¿Es un tecnico externo?',
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => [true => 'No', false => 'Si'],
                    'options' => ['inline' => true, 'default' => 'No',
                    'disabled' => true]
                ],
            ]
        ])
        ?>
    
        <div id="aprobacion_tecnico">
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'id_area_tecnica' => [
                    'label' => 'Area encargada de la revisión',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data' => yii\helpers\ArrayHelper::map($area, 'cod_desempenio','desc_desempenio'),
                        'options' => ['placeholder' => 'Seleccione el area encargada de la revisión'],
                        
                    ]
                ],

            ]
        ]);
        ?>
        <?= Form::widget([    
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'comentario' => [
                    'label' => 'Comentario',
                    'type' => Form::INPUT_TEXTAREA,
                    'id' => 'comentario',
                    'options' => ['style' => 'text-align: center'],
                ]
            ]
            ])
            ?>
            <?php } ?>
    </div>
        <div class="form-group" align='center'>
         
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id'=>'btGuardar','class' => 'btn btn-primary']) ?>
            
    </div> 
    <?php ActiveForm::end(); ?>
    
    </div>     
<?php

$script = <<< JS
$('#btnProveedor').click(function(){
      alert(objdata)
  })

   $("#actarecepciondetalle-necesidad_aprobacion").click(function(){
    var valorRadioButton = $("input[name='ActaRecepcionDetalle[necesidad_aprobacion]']:checked").val();  
    valorRadioButton = Number(valorRadioButton);
    
     if(valorRadioButton === 0 ){
        
     $("#aprobacion_tecnico").hide();
     }else {
     $("#aprobacion_tecnico").show();
    }});
    $('#btGuardar').click(function(){
        var valorRadioButton = $("input[name='ActaRecepcionDetalle[necesidad_aprobacion]']:checked").val();  
        valorRadioButton = Number(valorRadioButton);
        var area = $('#actarecepciondetalle-id_area_tecnica').val();
        if(area == '' && valorRadioButton ==1){

            krajeeDialog.alert("Debe seleccionar el área a cargo de la revisión");
                return false;
        
        }
    });
    


JS;
$this->registerJs($script);
?>