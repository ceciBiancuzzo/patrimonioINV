<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use patrimonio\models\BienUso;
use patrimonio\models\SolicitudCab;
use patrimonio\models\SolicitudDet;
use patrimonio\parametros\PatrimonioEstadoInterno;

$estadoInterno = patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
//$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$bienes= patrimonio\models\BienUso::find()->all();
//$areas= patrimonio\parametros\PatrimonioArea::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Información',
    ]
    ]);

Modal::begin([
    'header' => '<h2>Detalle Solicitud</h2>',
    'headerOptions' => ['id' => 'modalDetalleHeader'],
    'id' => 'modalDetalle',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentDetalle'>Cargando... Espere...</div>";
Modal::end();     
//metodo para el titulo
$titulo="Solicitud";
if($model->tipo_solicitud == 1){ 
    $titulo = "Solicitud de un Bien";
    }else if($model->tipo_solicitud == 2){
        $titulo = "Solicitud de Reparación";
        }else if ($model->tipo_solicitud == 3){
            $titulo = "Solicitud de Baja";
                }

//$titulo = 'Solicitud de un Bien';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

$accion= ['create'];
if($model->id !=null ){
    $accion= ['update', 'id'=>$model->id];
}

//metodo para activar o desactivar campos segun el estado
if($model->id_estado!=1){
    $disable=true;
    }else {
        $disable = false;
    };
    
if ($model->id_estado==2) {
    $disable2=false;
}else{
    $disable2=true;
}
?>
<div class="evento-createsoli">
    <?php $form = ActiveForm::begin(['id' => 'Detalle','action'=>$accion]); ?> 
    <?=$form->field($model, 'id')->hiddenInput()->label(false); ?>
<div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            Datos del Solicitante
        </h3>
    </div>
<div class="panel-body" align="center">
    <div class="row">
        </div>   
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
                    'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',
                    'disabled'=>$disable,]
                ] 
            ],

            'fecha_solicitud'=>[
                'label'=>'Fecha de solicitud',
                'type'=>Form::INPUT_WIDGET, 
                'widgetClass'=> kartik\datecontrol\DateControl::class, 
                'options'=>[
                    'disabled'=>$disable,
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
                'label' => 'Departamento',
                'type' => Form::INPUT_TEXT,
                'options' => ['readOnly' => true]

            ],
            'str_seccion'=> [
                'label' => 'Sección',
                'type' => Form::INPUT_TEXT,
                'options' => ['readOnly' => true]
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
                    'disabled'=>$disable,
                    'data' => yii\helpers\ArrayHelper::map($tipoSolicitud, 'id','descripcion')],
                ],
                'id_estado' => [
                    'label' => 'Estado Solicitud',
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'disabled'=>true,
                        'data' => yii\helpers\ArrayHelper::map($estadosFormularios, 'id','descripcion')],
                ]
                
            ]   
        ]);
        ?> 
     </div>
    
    </div>
  

<div class="form-group" align="center">
    <?=Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary', 'disabled'=>$disable ])?>
    <?php ActiveForm::end();?>
</div>

<div class="detalle-solicitud">    
        <?php 
            $urlRegresar = "solicitud-cab/index";
            echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-primary']);           
            echo  '   ' . Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar Detalle', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['solicitud-cab/create-detalle']), 'class' => 'btn btn-success','disabled'=>$disable,]) ; 
    
    ?>

    <?php 
//metodo para los botones del update y delete detalles
    if ($model->id_estado == 1){
        $opcion_update = function ($url,$dataProviderDetalle) {
            return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                            ['title'=>'Editar Detalle','name' => 'btEditar', 
                                            'value' => \yii\helpers\Url::to(['solicitud-cab/update-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-info']);
            };

        $opcion_delete = function ($url,$dataProviderDetalle) {
            return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                            ['title'=>'Eliminar Detalle','name' => 'btEliminar',
                                            'value' => \yii\helpers\Url::to(['solicitud-cab/delete-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-danger']); 
        };
        }else{
            $opcion_update = function ($url,$dataProviderDetalle) {
            return ""; 
        };
            $opcion_delete =    function ($url,$dataProviderDetalle) {
            return "";
        };
    }
?>   

<?php //muestro los detalles
                $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                            ['attribute'=>'id_bien_uso',
                            'label'=>'Bien uso',
                            'value'=>function($model){
                                if($model->bienUso){
                                   return $model->bienUso->strBien;
                                }else{
                                    return "No identificado";
                                }
                            }
                        ],
                            ['attribute'=>'cantidad_solicitada',
                              'label'=>'Cantidad Solicitada',
                            ],
                           
                            ['attribute'=>'observaciones',
                             'label'=>'Observaciones'],
                          
                            ['class' => 'kartik\grid\ActionColumn',
                            'template' => ' {update}{delete}',
                            'buttons' => [
                                 'update' => $opcion_update, 
                                 'delete' => $opcion_delete,
                            ],
                        ],  
                        ];    
                ?>    
                <?= GridView::widget([
                        'id'=>'gridDetalle',
                        'dataProvider' => $dataProviderDetalle,
                        //'filterModel' => $model,
                        'columns' => $gridColumns,
                        'panel' => [
                           'type' => GridView::TYPE_INFO,
                           'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de Bienes</h3>',
                        ],  
                        'toolbar' =>  [
                            '{toggleData}',
                        ],        
                        'responsive' => true,
                        'containerOptions'=>['style'=>['white-space' => 'nowrap']], // only set when $responsive = false
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
                ?>
              </div>
        </div> 
               
    <?php  
$form = ActiveForm::begin(['id'=>'solicitudcab']); ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
<?php echo $model->id_estado == 2?Form::widget([    
                 'model'=>$model,
                 'form'=>$form,
                 'columns'=>1,
                 'attributes'=> [ 
                        'motivo_rechazo'=>['type'=>$model->id_estado > 5?Form::INPUT_STATIC:Form::INPUT_TEXTAREA],               
                    ],
                ]):'';       
            ?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
<?php echo $model->id_estado== 2? 
                Form::widget([    
                'model'=>$model,
                'form'=>$form,
                'columns'=>1,
                'attributes'=>  [ 
                'observaciones_aprobado'=>['type'=>$model->id_estado >4?Form::INPUT_STATIC:Form::INPUT_TEXTAREA], 
                'id_estado_interno'=>[
                'label' => 'Tipo de Baja',
                'id' => 'id_estado_interno',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($estadoInterno, 'id', 'denominacion'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Tipo de Baja',
                    ]
                ] ]        
                ],
            ]):'';
            ?>  
        <?= Html::Button('<span class="glyphicon glyphicon-check"></span> Presentar', ['id'=>'btPresentar','class' => 'btn btn-primary','disabled'=>$disable])?>     
        <?= Html::Button('<span class="glyphicon glyphicon-ok"></span>  Aprobar', ['id'=>'btAprobar','class' => 'btn btn-success','disabled'=>$disable2])?>
        <?= Html::Button('<span class="glyphicon glyphicon-remove"></span> Rechazar', ['id'=>'btRechazar','class' => 'btn btn-danger','disabled'=>$disable2])?>  
        <?php ActiveForm::end(); ?>
<?php

//$url = Url::to(['solicitud-cab/create-detalle']);     
$idsolicitudCab = $model->id?$model->id:"";
$token = Yii::$app->request->getCsrfToken();
$urlRechazar = \yii\helpers\Url::to(['rechazar','id'=>$model->id]);
$urlAprobar = \yii\helpers\Url::to(['aprobar','id'=>$model->id]);
$urlPresentar = \yii\helpers\Url::to(['presentar','id'=>$model->id]);
$url = Url::to(['solicitud-cab/datos-usuario']);
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    $("#btRechazar").click(function(){
        
        
        if($.trim($("#solicitudcab-motivo_rechazo").val()) == ""){
            krajeeDialog.alert("¡Debe ingresar un motivo de rechazo!");
            $("#solicitudcab-motivo_rechazo").val("");
            return;
        }

        krajeeDialog.confirm("Esta Seguro que quiere Rechazar esta Solicitud?", function (result) {
            if(result){
                $("#solicitudcab").attr("action","$urlRechazar").submit();
            }
        });
   });

   $("#btAprobar").click(function(){
        krajeeDialog.confirm("Esta Seguro que quiere Aprobar esta Solicitud?", function (result) {
            if(result){
                $("#solicitudcab").attr("action","$urlAprobar").submit();
            }
        });
   });
   
   $("#btPresentar").click(function(){
        krajeeDialog.confirm("Esta Seguro que quiere Presentar esta Solicitud?", function (result) {
            if(result){
                $("#solicitudcab").attr("action","$urlPresentar").submit();
            }
        });
   });

    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nuevo Detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
          
            .load($(this).attr("value")+'&id_solicitud_cab=$idsolicitudCab');

    });
    $("button[name*=\'btEditar\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Modificar detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value"));
           
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



function traerDatosUsuario(id){
        
        if($('#solicitudcab-id_usuario_solicitante').val().trim()!=''){        
            //alert(id)
            $.ajax({
                type: "GET",
                url:"$url",            
                data: "id="+id,
                
                success: function (response) {     
                    var datos = jQuery.parseJSON(response);
                    var datosUsuario = datos.datos;
                    var datosError = datos.error;
                    //console.log(datosUsuario)
                    if (datosUsuario.str_departamento==" "||datosUsuario.str_seccion=="") {
                        $("#solicitudcab-str_departamento").val("No hay datos disponibles");
                        $("#solicitudcab-str_seccion").val("No hay datos disponibles");
                    }else{
                    $("#solicitudcab-str_departamento").val(datosUsuario.str_departamento);
                    $("#solicitudcab-str_seccion").val(datosUsuario.str_seccion);
                    }
                    $("#solicitudcab-id_departamento").val(datosUsuario.id_departamento);
                    $("#solicitudcab-id_seccion").val(datosUsuario.id_seccion);
                }                
            });      
        } else {
            //alert('nada');
            krajeeDialog.alert("Error.");
            return false;           
        }    
    }            
    $("#solicitudcab-id_usuario_solicitante").change(function(){
        
        //console.log($("#solicitudcab-id_usuario_solicitante").val())
        traerDatosUsuario($('#solicitudcab-id_usuario_solicitante').val()); 
    });
    
    $('#btnGuardar').click(function(){
        
     });    

 
JS;

$this->registerJs($script);
?>
