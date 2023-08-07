<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use kartik\builder\TabularForm;
use kartik\popover\PopoverX;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;
use kartik\dialog\Dialog;
use patrimonio\parametros\PatrimonioMarca;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\models\ActaTransferenciaDet;
use patrimonio\parametros\PatrimonioRubro;
use kartik\widgets\SwitchInput;

use kartik\widgets\Spinner;


Modal::begin([
    'header' => '<h2>   Carga Imagen</h2>',
    'id' => 'activity-modal-import',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentImport'>Cargando... Espere...</div>";
Modal::end();
Modal::begin([
    'header' => '<h2> ' . 'Imagenes bien </h2>',
    'headerOptions' => ['id' => 'modalViewImagen'],
    'id' => 'modalImagen',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style' => 'overflow:scroll;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);

echo "<div id='modalContentDetalle'>Cargando... Espere...</div>";
Modal::end();
$perfil = '';
$busco_perfiles = Yii::$app->session->get('perfiles');
foreach ($busco_perfiles[17] as $roles){             //17 es el numero de la aplicacion de Patrimonio
    $perfil = $perfil . '-' . $roles;
} 
$vidaUtil= patrimonio\parametros\PatrimonioRubro::find()->all();
$marcas= patrimonio\parametros\PatrimonioMarca::find()->where(['fecha_baja' => null])->all();
$rubro = patrimonio\parametros\PatrimonioRubro::find()->where(['fecha_baja' => null])->all();
$estados= patrimonio\parametros\PatrimonioEstadoInterno::find()->where(['fecha_baja' => null])->all();
$condiciones = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$estadoBien = patrimonio\parametros\PatrimonioEstadoInterno::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
$seccion = gestion_personal\models\PersonalOrganigrama::find()->all();
$dependencias = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
if ($model->id_estado_interno!=1) {
    $disable=true;
}else {
    $disable = false;
};
// $disable = false;
// $valor = false;
// if ($model->estado == 1) {
//     $disable = true;
// } else {
//     $disable = FALSE;
// }
// echo kartik\dialog\Dialog::widget([
//     'libName' => 'krajeeDialogCust', // a custom lib name
//     'overrideYiiConfirm' => false,
//     'options' => [
//         'title' => 'Información',
//     ]
//     ]);


    $session = Yii::$app->session;
    echo Dialog::widget([
        'libName' => 'krajeeDialog', // a custom lib name
        'overrideYiiConfirm' => false,
        'options' => [
            'title' => 'My Dialog',
        ]
        ]);
   
    

$this->title = 'Bien de uso';
$this->params['breadcrumbs'][] = ['label' => 'Bien']; 
$this->params['breadcrumbs'][] = "ID: " . $model->id; 
$accion= ['create'];    //accion create
if($model->id !=null ){
    $accion= ['update', 'id'=>$model->id];  //accion update

}

$form = ActiveForm::begin(['id' => 'detalle ','action'=>$accion]); 
?>
<div class="well" align='center'>
    <div class="panel panel-primary">
        <h4>Nueva Registro de Bien</h4>
    </div>
<div class="evento-createbien">
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
             <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            DATOS DEL ESTADO DEL BIEN
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>   
               <!--  ?= 
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
 
                            ]]
                            ]
                            ]
                            )
                            ?>  -->  
                            <?=
                              FormGrid::widget([
                                'model' => $model,
                                'form' => $form,
                                'autoGenerateColumns' => true,
                                'rows' => [
                                [
                                    'attributes' => [ 
                                        'id_estado_interno' => ['label' => 'Estado interno ', 'type' => Form::INPUT_WIDGET, 
                                        'widgetClass' => '\kartik\widgets\Select2',
                                        'options' => [
                                            'data'=>yii\helpers\ArrayHelper::map($estados,'id','denominacion'),
                                        'options' => ['disabled' => false], 
                                        ]],
                                        'id_condicion' => ['label' => 'Condición del bien', 'type' => Form::INPUT_WIDGET, 
                                        'widgetClass' => '\kartik\widgets\Select2',
                                        'options' => [
                                            'data'=>yii\helpers\ArrayHelper::map($condiciones,'id','descripcion'),
                                         'options' => ['disabled' => false], 
                                        ]],
                                 
                                    ]   
                                ]
                ]]);
            ?>
        <?=
                              FormGrid::widget([
                                'model' => $model,
                                'form' => $form,
                                'autoGenerateColumns' => 3,
                                'rows' => [
                                    [
                                        'attributes' => [ 
                              
        
                                'id_dependencia' => ['label' => 'Dependencia', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                   'data'=>yii\helpers\ArrayHelper::map($dependencias,'id','strDependencia'),
                                   'disabled' => false, 
                                ]],
                                'id_usuario_bien' => ['label' => 'Usuario en posesión del bien', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($usuario,'id','strAgente'),
                                    'disabled' => true, 
                                    'options' => ['placeholder'=>'-'], 
                                    ]],     
                                //'options' => ['placeholder'=>'-'], 

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
            CARACTERÍSTICAS DEL BIEN
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
                                    'options' => ['placeholder' => 'Seleccione el rubro','disabled' => $disable], 
                                ]],
                                 
                            
                            'id_marca' => ['label' => 'Marca ', 'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                            'data'=>yii\helpers\ArrayHelper::map($marcas,'id','denominacion'),
                            'options' => ['placeholder' => 'Seleccione la marca','disabled' => $disable],
                           
                        ]
                            ],             
                            
                            'modelo' => ['type' => Form::INPUT_TEXT, 
                            'options' => ['placeholder' => 'Indique el modelo','disabled' => $disable], 
                            ], 
                           
                            'fecha_carga'=> [
                                'label' => 'Fecha de carga',
                                'pluginOptions' => [
                                'format' => 'dd/mm/yyyy',    
                                ],
                                'type' => Form::INPUT_TEXT,
                                    'options' =>  [
                                  
                                            'readOnly' => true,
                                        ],
                              
                                 ],
                           
                           
                        ],
                    ]
                ]]);
            if(strpos($perfil,'Administrador' || strpos($perfil, 'Agente')== 1)){
                echo $this->context->renderPartial('_form_marca');
            }
                ?>
                
                <?=
                FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                            
                                'nro_serie' => ['type' => Form::INPUT_TEXT, 
                            'options' => ['placeholder' => 'Indique el número de serie','disabled' => $disable], 
                            ], 
                                
                                'descripcion_bien' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Descripción del bien', 'options' => ['placeholder' => 'Por favor, ingrese la descripcion del bien','disabled' => $disable]],
                                'tipo_bien'=> ['type'=>Form::INPUT_TEXTAREA, 
                                'options' => ['placeholder' => 'Indique el tipo de bien','disabled' => $disable], 
                                ], 
                                'cantidad'=> ['type'=>Form::INPUT_TEXT, 
                                'options' => ['placeholder' => 'Indique la cantidad','disabled' => $disable], 
                                ],
                                
                            ]
                        ],
                    ]
                ]);
            
               
                
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
                                'nro_inventario' => ['label' => 'Número de inventario', 'type' => Form::INPUT_TEXT, 
                                'options' => ['placeholder' => 'Indique el número de inventario','readOnly' =>true], 
                                ],                                   
                                'faltante'=>[   // radio list
                                    'type'=>Form::INPUT_RADIO_LIST, 
                                    'items'=>[true=>'Si', false=>'No'], 
                                    'options'=>['inline'=>true]
                                ],    
                              'tipo_identificacion' => [
                              'label'=>'Tipo de identificación',
                              'type'=>Form::INPUT_TEXT,
                              'options' => ['placeholder' => 'Indique el tipo de identificación']],
                            ]]]])
                            ?>   
                              
        
                            <?=
                              FormGrid::widget([
                                'model' => $model,
                                'form' => $form,
                                'autoGenerateColumns' => true,
                                'rows' => [
                                    [
                                        'attributes' => [ 
                              'propiedad_bien' => ['label' => 'Propiedad del bien ', 'type' => Form::INPUT_WIDGET, 
                              'widgetClass' => '\kartik\widgets\Select2',
                              'options' => [
                            'data' => ['1' => 'INSTITUTO NACIONAL DE VITIVINICULTURA', '2' => 'TERCERO'],  
                              ]],
                              /* 'ubicacion_bien' => [
                                  'label' => 'Ubicación del bien',
                                  'type' => Form::INPUT_TEXT,
                              ], */
                              'id_acta_recepcion_definitiva' => [
                                'label' => 'Número acta de recepción',
                                'type' => Form::INPUT_TEXT,
                                'options' => ['readOnly' =>true], 
                              ],
                              'codigo_item_catalogo' => [
                                'label'=>'Código item',
                                'type'=>Form::INPUT_TEXT,
                                'options' => ['placeholder' => 'Indique el código']],
                              
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
            DATOS AMORTIZACION
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
                              
                                'precio_origen'=> [
                                    'label' => 'Valor de origen',
                                    'type' => Form::INPUT_TEXT,
                                    // 'options' => ['readOnly' => true]
                                    
                                ],


                                'anio_alta'=> [
                                    'label' => 'Año de alta',
                                    'pluginOptions' => [
                                    'format' => 'yyyy',    
                                    ],
                                    'type' => Form::INPUT_TEXT,
                                        'options' =>  [
                                      
                                                'readOnly' => true,
                                            ],
                                  
                                     ],
                                     'vida_util'=> [
                                        'label' => 'Vida Util',
                                       'type' => Form::INPUT_TEXT,
                                          'options' => [
                                            'readOnly' => false,
                                          'value'=>$model->vida_util?$model->vida_util:"-",                                                                    
                                          
                                        
                                         /* $model->rubro->nro_anos_vida_util?$model->rubro->nro_anos_vida_util:"-",                                                                    
                                             'readOnly' => false,  */
                                            ]
                                        ],
                                        'vida_util_transcurrida'=> [
                                            'label' => 'Vida útil transcurrida',
                                            'type' => Form::INPUT_TEXT,
                                            'options' => [                                               
                                                   
                                                    'readOnly' => true,
                                                ],
                                            
                                            ] ,
                                                          
                                        ],
                                    ]
                                ]         
                                    
                                
                            
                        ]);   ?>
                         <?=

                          FormGrid::widget([
                           'model' => $model,
                           'form' => $form,
                            'autoGenerateColumns' => true,
                            'rows' => [
                                        [
                                            'attributes' => [
                                            'amortizacion_anual'=> [
                                            'label' => 'Amortización anual',
                                            'type' => Form::INPUT_TEXT,
                                            'options' => [
                                                      'readOnly' => true,
                                                                    ],
                                                                
                                                            ], 
                                            'amortizacion_anual_acumulada'=> [
                                                'label' => 'Amortización anual acumulada',
                                                'type' => Form::INPUT_TEXT,
                                                'options' => [
                                                    
                                                       
                                                        'readOnly' => true,
                                                    ],
                                                
                                            ], 
                                            'valor_residual'=> [
                                                'label' => 'Valor residual',
                                                'type' => Form::INPUT_TEXT,
                                                'options' => [
                                                    
                                                       
                                                        'readOnly' => true,
                                                    ],
                                                
                                            ], 
                                            'valor_rezago'=> [
                                                'label' => 'Valor de rezago',
                                                'type' => Form::INPUT_TEXT,
                                                'options' => [
                                                    
                                                       
                                                        'readOnly' => true,
                                                    ],
                                                
                                            ], 
                                      
                                     
                                    ],
                            ]
                        ]         
                            
                        
                    
                ]);
                ?>
            <?=
            FormGrid::widget([
            'model' => $model,
            'form' => $form,
            'autoGenerateColumns' => true,
            'rows' => [
                        [
                        'attributes' => [
                            'amortizable' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => kartik\switchinput\SwitchInput::class,
                                        'options' => [
                                            
                                            'type' => kartik\widgets\SwitchInput::CHECKBOX,
                                            'pluginOptions' => [
                                                'onText' => 'SI',
                                                'offText' => 'NO',
                                                'onColor' => 'success',
                                                'offColor' => 'danger',
                                                
                                            ],
                                            
                                        ],
                                    ],
                                ]
                            ]   
                        ]                     
                    ]);
                ?>
        
    </div>
</div>


        <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            DATOS ADMINISTRATIVOS
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
                                'acto_admin' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Acto administrativo',],
                                'observaciones'=> ['type'=>Form::INPUT_TEXTAREA, 
                                'label'=>'Observaciones',],
                                'obvs_admin'=> ['type'=>Form::INPUT_TEXTAREA, 
                                'label'=>'Cargo anterior a la baja',],
                                'fecha_baja_definitiva'=>[
                                    'label'=>'Fecha de baja definitiva',
                                    'type'=>Form::INPUT_WIDGET, 
                                    'widgetClass'=> kartik\datecontrol\DateControl::class, 
                                    'options'=>[
                                        'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                                        'widgetOptions'=>[
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'todayHighlight' => true,
                                             
                                            ],
                                        ]
                                    ]
                                ],
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
         <?php  if(strpos($perfil,'Administrador')){?>
     <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary']) ;?>
     <span><?= Html::Button('<span class="glyphicon glyphicon-import"></span> Agregar Imagen', ['id' => 'btnImagen', 'class' => 'btn btn-success','value'=>Url::to(['bien-uso/upload-file',
                'id'=>$model->id])]) ?></span>
             
        <span><?= Html::Button('<span class="glyphicon glyphicon-import"></span> Ver Imagen', ['name' => 'btView', 'class' => 'btn btn-warning','value'=>Url::to(['bien-uso/ver-imagen',
                'id'=>$model->id])]) ?></span>   

    <?php } ?> 

     <?php ActiveForm::end(); ?>
  

</div>
<?php

 if($model->getAttribute('id') != null){?>
     <div class="row" >
         <?php
             $items = [
                         [
                             'label'=>'<i class="glyphicon glyphicon-home"></i> Detalles contables',
                             'content'=>$this->render('index_detalles_contables',['dataProviderContables'=>$dataProviderContables,'model'=>$model]),
                             'active'=>true
                         ],
                         [
                             'label'=>'<i class="glyphicon glyphicon-home"></i> Detalles garantia',
                             'content'=>$this->render('index_detalles_garantia',['dataProviderGarantia'=>$dataProviderGarantia,'model'=>$model]),
                             'active'=>false
                         ],
                                             [
                             'label'=>'<i class="glyphicon glyphicon-home"></i> Detalles seguro',
                             'content'=>$this->render('index_detalles_seguro',['dataProviderSeguro'=>$dataProviderSeguro,'model'=>$model]),
                             'active'=>false
                         ],

             ];
      
             echo TabsX::widget([
                 'items'=>$items,
                 'position'=>TabsX::POS_ABOVE,
                 'encodeLabels'=>false
             ]);

         ?>
         </div>
         

 <?php 
 }
?>
    <?php
        $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
        ['attribute'=>'id','label'=>'ID'],
                           // ['attribute'=>'ejercicio','label'=>'Ejercicio'],
                            ['attribute'=>'Motivo','label'=>'Fecha de alta'],
                            ['class' => 'kartik\grid\ActionColumn',
                            'template' => ' {update}{delete}',
                            'buttons' => [
                                // 'update' => $opcion_update, 
                                // 'delete' => $opcion_delete,
                            ],
                        ],  
                        ];    
                ?>    
                <div class="dvd">
                    <div class="producto"></div>
                    <div class="secondtable"></div>
                </div>
                
<?php  

$url = Url::to(['bien-uso/create-cabecera']);     
$idBienUso = $model->id?$model->id:"";
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS

    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nuevo detalle contable");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_bien_uso=$idBienUso');
    });
    $('#btnImagen').click(function() {    
                    $.get($(this).val(),{},
                        function (data) {
                            $('#modalContentImport').html(data);
                            $('#activity-modal-import').modal();
                        }  
                    );
                });
        
  
    $("button[name*=\'btEditar\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Modificar detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_bien_uso=$idBienUso');
    });
 
    $("button[name*=\'btView\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Ver detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_bien_uso=$idBienUso');
    });
  
    $("#modalDetalle").on("hidden.bs.modal", function() {
        $("#modalContentDetalle").html("Cargando... Espere...");
    });    
    $('form').submit(function() {
        
        // $("#btnGuardar").prop('disabled',true);     
   });  
   $("button[name*=\'btView\']").click(function(){
       $("#modalViewImagen").find("h2").html(" ");
        $("#modalImagen").modal("show")
        .find("#modalContentDetalle")
        .load($(this).attr("value")+'&id=$idBienUso');
    });
JS;
$this->registerJs($script);
?>
