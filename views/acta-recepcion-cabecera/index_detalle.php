<<<<<<< HEAD
=======

>>>>>>> aprobacion_bodega-gerFinal
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\builder\FormGrid;
use kartik\datecontrol\DateControl;
use kartik\tabs\TabsX;
use patrimonio\parametros\Proveedor;

use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\models\ActaRecepcionDetalle;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use gestion_personal\models\PersonalOrganigrama;
<<<<<<< HEAD

$delegacion = Yii::$app->user->identity->id_delegacion;
=======
>>>>>>> aprobacion_bodega-gerFinal
$perfil = '';
$busco_perfiles = Yii::$app->session->get('perfiles');
foreach ($busco_perfiles[17] as $roles){             //17 es el numero de la aplicacion de Patrimonio
    $perfil = $perfil . '-' . $roles;
} 
<<<<<<< HEAD
=======

$delegacion = Yii::$app->user->identity->id_delegacion;

>>>>>>> aprobacion_bodega-gerFinal
$seccion= patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
$condicion = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$formaAdquisicion = patrimonio\parametros\PatrimonioFormaAdquisicion::find()->where(['fecha_baja' => null])->all();
$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$comision= patrimonio\models\PatrimonioComision::find()->where(['fecha_baja'=>null])->andWhere(['activa'=>true])->andWhere(['id_delegacion' => $delegacion])->all();

echo kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'InformaciónN',
    ]
    ]);

Modal::begin([
    'header' => '<h2>Detalle Recepcion</h2>',
    'headerOptions' => ['id' => 'modalDetalleHeader'],
    'id' => 'modalDetalle',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:scroll;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentDetalle'>Cargando... Espere...</div>";
Modal::end();     
Modal::begin([
    'header' => '<h2>Revisión técnica</h2>',
    'headerOptions' => ['id' => 'modalAprobacionHeader'],
    'id' => 'modalAprobacion',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentAprobacion'>Cargando......</div>";
Modal::end();    
Modal::begin([
    'header' => '<h2>Carga de número de serie</h2>',
    'headerOptions' => ['id' => 'modalCargaHeader'],
    'id' => 'modalCarga',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentCarga'>Cargando......</div>";
Modal::end();  
$this->title = 'Acta Recepcion';
$this->params['breadcrumbs'][] = ['label' => 'Acta Recepcion']; 
$this->params['breadcrumbs'][] = "Acta Recepcion ID: " . $model->id; 
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    //foreach ($_SESSION['perfiles'][1] as $roles){
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 

$accion= ['create'];

if($model->id !=null ){
    $accion= ['update', 'id'=>$model->id];
}


if($model->id_estado!=1 || $model->detalles==null){
    $disable=true;
}else {
    $disable = false;
};

if ($model->id_estado==2) {
    $disable2=false;
}else{
    $disable2=true;
} 

if ($model->id_estado==3) {
    $disable3=true;
}else{
    $disable3=false;
}

if ($model->id_estado!=1) {
    $disable4=true;
}else {
    $disable4 = false;
};
?>
       
<div class="_form" align='center'>   
    <?php $form = ActiveForm::begin(['id' => 'actarecepcioncabecera','action'=>$accion]);?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

<div class="panel panel-primary" style="width:100%;margin-left:0px;margin-right:0px">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> DATOS GENERALES DE LA RECEPCION   </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?= 
                    Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 3,
                        'attributes' => [ 
                            'id_dependencia'=> [
                                'label' => 'Dependencia de Recepcion',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'id' => 'id_delegacion',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($seccion, 'id', 'strDependencia'),
                                    'options' => [
                                        'placeholder' => 'Seleccione Seccion de Recepcion',
                                        'disabled'=>$disable3,
                                    ]
                                ]
                            ],
                            'fecha_acta' => [
                                'label' => 'Fecha de Acta',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => kartik\date\DatePicker::classname(),
                                'useWithAddon' => true,
                                'convertFormat' => true,
                                'options' => [
                                        'disabled'=>$disable3,
                                        'pluginOptions' => [
                                            'locale' => [
                                                'format' => 'DD/MM/YYYY',
                                            ]
                                        ]
                                ]
                            ],
                            'nro_acta'=> [
                                'label' => 'Numero de Acta',
                                'type' => Form::INPUT_TEXT,
                                'options' => [
                                    'placeholder' => 'Ingrese numero de acta',
                                    'disabled'=>true,
                                ]
                            ],
                            'orden_compra'=> [
                                'label' => 'Orden de compra',
                                'type' => FORM::INPUT_TEXT,
                                'options' => [
                                    'placeholder' => 'Ingrese orden de compra',
                                    'disabled'=>$disable3,
                                ]
                            ],
                            'nro_expediente'=> [
                                'label' => 'Numero de Expediente',
                                'type' => Form::INPUT_TEXT,
                                'options' => [
                                    'placeholder'=> 'Ingrese numero de expediente',
                                    'disabled'=>$disable3,
                                ]
                            ],
                            'id_forma_adquisicion' => [
                                'label' => 'Forma de Adquisicion',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($formaAdquisicion, 'id', 'denominacion'),
                                    'options' => [
                                        'placeholder' => 'Seleccione Forma de Adquisicion',
                                        'disabled'=>$disable3,
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
                        'columns' => 3,
                        'attributes' => [
                            'nro_gde' => [
                                'label' => 'Numero de GDE',
                                'type' => Form::INPUT_TEXT,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'id' => 'Numero GDE',
                                'options' => [
                                    'label' => 'Ingrese numero de GDE',

                                ]
                            ],
                            'id_estado' => [
                                'label' => 'Estado Solicitud',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'id' => 'Estado Solicitud',
                                'options' => [
                                    'disabled'=> 'true',
                                    'data' => yii\helpers\ArrayHelper::map($estadosFormularios, 'id','descripcion')
                                ],
                            ],
                            'id_comision'=> [
                                'label' => 'Comision de Recepción',
                                'type' => Form::INPUT_WIDGET,
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($comision, 'id', 'denominacion'),
                                    'options' => [
                                        'placeholder' => 'Seleccione Comisión de Recepción',
                                        'disabled'=>$disable3,
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
                    'columns' => 1,
                    'attributes' => [
                        'observacion_acta' => [
                            'label' => 'Observacion',
                            'type' => Form::INPUT_TEXTAREA,
                            'options' => [
                                'placeholder' => 'Ingrese observacion',
                                'disabled'=>$disable4,
                            ]
                        ]
                    ]
                 ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Operario')== 1){
  ?>
<div class="form-group" align="center">
<<<<<<< HEAD
    
=======
>>>>>>> aprobacion_bodega-gerFinal
    <?=Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary'])?> 
</div>
<?php } ?>

<?php
ActiveForm::end();
?>
</div>

<div class="acta-recepcion-cabecera">    
    <p> 
        <?php 
             $urlRegresar = "acta-recepcion-cabecera/index";       
             echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-info']);                       
             
            if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Operario')== 1){
             echo  '   ' . Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar bien', 
             ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/create-detalle']), 'class' => 'btn btn-success','disabled'=>$disable4]) ; 
            }
        ?>                   
    <?php

     if($model->getAttribute('id') != null){?>
         <div class="row" >
             <?php
                 $items = [
                          
                             [
                                 'label'=>'<i class="glyphicon glyphicon-home"></i> Detalles',
                                 'content'=>$this->render('index_detalles_cabecera',['dataProviderDetalle'=>$dataProviderDetalle,'model'=>$model]),
                                 'active'=>false
                             ],
                             [
                                'label'=>'<i class="glyphicon glyphicon-home"></i> Bienes',
                                'content'=>$this->render('index_detalles_bienes',['dataProviderBienes'=>$dataProviderBienes,'model'=>$model]),
                                'active'=>true
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
        <!-- if ($model->id_estado == 1){
            
            $opcion_update = function ($url,$dataProviderDetalle) {
                return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                            ['title'=>'Editar Detalle','name' => 'btEditar', 
                                            'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/update-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-info']);
            };
            $opcion_delete = function ($url,$dataProviderDetalle) {
                return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                            ['title'=>'Eliminar Detalle','name' => 'btEliminar',
                                            'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/delete-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-danger']); 
            };
            $carga_serie = function($url,$dataProviderDetalle){            //print_r($model);die();

                return "   ".Html::button('<span class="glyphicon glyphicon-plus-sign"></span>', 
                ['title'=>'Cargar número','name' => 'btCarga', 
                'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/carga-serie',
                'id'=>$dataProviderDetalle->id_bien_uso]),'class' => 'btn btn-info'
            ]);
            };
            // if($model->detalles != null){
                // foreach($model->detalles[0] as $item){
                //     print_r($item);
                //     die();
                //     if($item->necesidad_aprobacion == 0){
                         
            $opcion_aprobacion = function ($url,$dataProviderDetalle) {
                if($dataProviderDetalle->necesidad_aprobacion == true){
                    return "   ".Html::button('<span class="glyphicon glyphicon-ok"></span>', 
                            ['title'=>'Aprobación técnica','name' => 'btAprobacionTecnica',
                            'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/aprobacion-tecnica',
                            'id'=>$dataProviderDetalle->id]),
                            'class' => 'btn btn-warning']); 
                        };
                        if($dataProviderDetalle->necesidad_aprobacion != true){
                            return "   ".Html::button(
                                '<span class="glyphicon glyphicon-remove"></span>',
                                ['class'  => 'btn btn-info',
                                'disabled' => true]);
                  
                        }
                    };
            // }
            // }else{
            //     $opcion_aprobacion = function ($url,$dataProviderDetalle){
            //     return "-";
            //                 };
            //     }
        }else{
            $opcion_update = function ($url,$dataProviderDetalle) {
            return ""; 
                };
            $opcion_delete =    function ($url,$dataProviderDetalle){
            return "";
                };
            $opcion_aprobacion = function ($url,$dataProviderDetalle){
                return "-";
                    };
        }
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute'=>'id_bien_uso',
                    'label'=>'Bien de Uso',
                    'value'=>function($model){
                        return $model->bienUso->tipo_bien;
                    },
                ],
                [
                    'attribute'=>'id_rubro',
                    'label'=>'Rubro',
                    'value'=>function($model){
                        return $model->bienUso->rubro->strRubro?$model->bienUso->rubro->strRubro:"-";
                    },
                ],    
                [
                    'attribute'=>'Marca',
                    'label'=>'Marca',
                    'value'=>function($model){
                        return $model->bienUso->marcas?$model->bienUso->marcas->denominacion:"-";
                    },
                ],    
                [
                    'attribute'=>'nro_serie',
                    'label'=>'Número de serie',
                    'value'=>function($model){
                        return $model->bienUso->nro_serie?$model->bienUso->nro_serie:"-";
                    },
                ],    
                [
                    'attribute'=>'Descripción del bien',
                    'label'=>'Descripción',
                    'value'=>function($model){
                        return $model->bienUso->descripcion_bien?$model->bienUso->descripcion_bien:"-";
                    },
                ],    
                [
                    'attribute'=>'modelo',
                    'label'=>'Modelo',
                    'value'=>function($model){
                        return $model->bienUso->modelo;
                    },
                ], 
                
                [
                    'attribute'=>'garantia',
                    'label'=>'Garantia'
                ],           
                [
                    'attribute'=>'cantidad',
                    'label'=>'Cantidad'
                ],
                [
                    'attribute'=>'id_proveedor',
                    'label'=>'Proveedor',
                    'value'=>function($model){
                        return $model->proveedor->denominacion;
                    }
                ],
                ['class' => 'kartik\grid\ActionColumn',
                    'template' => ' {update}{delete}{aprobacion-tecnica}{carga-serie}',
                    'buttons' => [
                    'update' => $opcion_update, 
                    'delete' => $opcion_delete,
                    'aprobacion-tecnica' => $opcion_aprobacion,
                    'carga-serie' => $carga_serie,
                    ],
                ],  
            ];
    ?>   -->
      
                <!-- ?= GridView::widget([
                        'id'=>'gridDetalle',
                        'dataProvider' => $dataProviderDetalle,
                        //'filterModel' => $model,
                        'columns' => $gridColumns,
                        'panel' => [
                           'type' => GridView::TYPE_INFO,
                           'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de Detalles</h3>',
                        ],  
                        'toolbar' =>  [
                            '{toggleData}',
                        ],        
                        'responsive' => true,
                        'containerOptions'=>['style'=> ['white-space' => 'nowrap']], // only set when $responsive = false
                        'headerRowOptions'=>['class'=>'kartik-sheet-style'],        
                        'hover' => true,
                        'bordered' => true,
                        'striped' => false,
                        'condensed' => true,
                        'hover' => true,
                        'showPageSummary' => false,
                        'pjax'=>true, 
                        'persistResize' => false,
                        'exportConfig' => false,
                        'exportConfig' => false,
                ]);
                ?> -->
                <?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Operario')== 1){
  ?>
        <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar', ['id'=>'btPresentar','class' => 'btn btn-primary','disabled'=>$disable])?>  
        <?= Html::Button('<span class="glyphicon glyphicon-ok"></span>  Aprobar', ['id'=>'btAprobar','class' => 'btn btn-success','disabled'=>$disable2]) ?>
        <?= Html::Button('<span class="glyphicon glyphicon-remove"></span> Rechazar', ['id'=>'btRechazar','class' => 'btn btn-danger','disabled'=>$disable2]) ?>
    <?php } ?>    
<?php  
$archivo ='';
if(!empty($model->detalles)){
$archivo = $model->detalles[0]->archivo;
}
$url = Url::to(['acta-recepcion-cabecera/create-detalle']);  
$urlPresentar = \yii\helpers\Url::to(['presentar','id'=>$model->id]);
$urlAprobar = \yii\helpers\Url::to(['aprobar','id'=>$model->id]);   
$urlRechazar = \yii\helpers\Url::to(['rechazar','id'=>$model->id]);
$idCab = $model->id?$model->id:"";
$token = Yii::$app->request->getCsrfToken();
//print_r($dataProviderDetalle);die();
$idAprobacion = null;
foreach($dataProviderDetalle->models as $id){
    $idAprobacion = $id->id_cab;
 }


$script = <<< JS

    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nuevo Detalle de Recepcion");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
          
            .load($(this).attr("value")+'&id_cab=$idCab');

    });
        
    $("button[name=\'btEliminar\']").click(function(){
        var url_detalle = $(this).attr("value");
        krajeeDialog.confirm("Desea eliminar el detalle?", function (result) {

            if(result){
                $.ajax({
                    url: url_detalle,
                    type: "post",
                    data: {
                              _csrf : "$token"
                          },
                    success: function (data) {                                         
                    }
                });
            }
        });
    });
    $("button[name*=\'btEditar\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Modificar detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_cab=$idCab');
    });
    $("button[name*=\'btCarga\']").click(function(){
        $("#modalCargaHeader").find("h2").html("Carga de número de serie");
        $("#modalCarga").modal("show")
            .find("#modalContentCarga")
            .load($(this).attr("value"));
    });
    //$("button[name*=\'btAprobacionTecnica\']").click(function(){
    $("button[name*=\'btAprobacionTecnica\']").click(function(){ 
        
        $("#modalAprobacionHeader").find("h2").html("Revisión técnica");
        $("#modalAprobacion").modal("show")
            .find("#modalContentAprobacion")
            .load($(this).attr("value")+'&id_cab=$idAprobacion');
          //  .load($(this).attr("value")+'?id=$model->id');
         //   $("#actarecepcioncabecera").attr("action","$urlAprobar").submit();
           
    });
    $("button[name*=\'btView\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Ver detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_cab=$idCab');
    });
    
    $("#btPresentar").click(function(){
        krajeeDialog.confirm("Esta seguro que quiere presentar el Acta de Recepcion?", function (result) {
  
            if(result){
                $("#actarecepcioncabecera").attr("action","$urlPresentar").submit();
            }
        });
   });

   $("#btPrint").click(function(){
    
    window.open('garantias/$archivo');
    
 
    });

   $("#btAprobar").click(function(){
        krajeeDialog.confirm("Esta Seguro que quiere Aprobar esta Solicitud?", function (result) {
            if(result){
                $("#actarecepcioncabecera").attr("action","$urlAprobar").submit();
            }
        });
   });

   $("#btRechazar").click(function(){
        // if($.trim($("#actarecepcioncabecera").val()) == ""){
        //     krajeeDialog.alert("¡Debe ingresar un motivo de rechazo!");
        //     $("#solicitudcab-motivo_rechazo").val("");
        //     return;
        // }
        krajeeDialog.confirm("Esta Seguro que quiere rechazar este Acta de Recepcion?", function (result) {
            if(result){
                $("#actarecepcioncabecera").attr("action","$urlRechazar").submit();
            }
        });
   });

   $("#modalAprobacion").on("hidden.bs.modal", function() {
        $("#modalContentAprobacion").html("Cargando... ...");
    });    
 
    $("#modalDetalle").on("hidden.bs.modal", function() {
        $("#modalContentDetalle").html("Cargando... Espere...");
    });    
    $('form').submit(function() {
        
        // $("#btnGuardar").prop('disabled',true);     
   });  

JS;
$this->registerJs($script);
?>
<<<<<<< HEAD
</div>
=======
</div>
>>>>>>> aprobacion_bodega-gerFinal
