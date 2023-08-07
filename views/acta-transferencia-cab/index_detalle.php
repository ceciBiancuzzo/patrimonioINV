<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
//use kartik\Form\ActiveForm;
use kartik\builder\FormGrid;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\models\ActaTransferenciaDet;


$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
  
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 
    $encargado = false; //Creo variable encargado
    //Comparo el area que transfiere y busco su denominacion para mas abajo comparar si coincide con quien esta transfiriendo y permitirlo
    if($model->areaTransferencia != null){
        $strDependencia=$model->areaTransferencia->id;
    }else{
        $strDependencia = null;
    }
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(['id' => $strDependencia])->one();
    if($areaTransfiere != null){
    $encargadoTransferencia = $areaTransfiere->id_encargado;
    $encargadoTransferencia2 = $areaTransfiere->id_encargado2;
    $encargadoTransferencia3 = $areaTransfiere->id_jefe;

    }else{
        $encargadoTransferencia = null;
    }
    //buscado id agente usuario
    $user = Yii::$app->user->identity->id_agente;

    if($user == $encargadoTransferencia || $user == $encargadoTransferencia2 ||  $user == $encargadoTransferencia3){
        $encargado = true;
    }else{
        $encargado =false;
    }
    //Busco el id agente del usuario y busco el id del area que recepciona y tambien recupero el area que recibe
    if($model->areaRecepciona != null){
        $strDependencia2=$model->areaRecepciona->id;
    }else{
        $strDependencia2 = null;
    }
    $areaRecibe = patrimonio\parametros\PatrimonioDependencia::find()->where(['id' => $strDependencia2])->one();
    // print_r($areaRecibe);die();
    //Una vez que tengo esos datos, busco el id del encargado de ese area que recepciona, y con eso lo comparo con el user de la sesion y veo
    //si es el encargado del area que recepciona    print_r($areaTransfiere);die();

    if($areaRecibe != null){
        $encargadoRecepcion = $areaRecibe->id_encargado;
        $encargadoRecepcion2 = $areaRecibe->id_encargado2;
        $encargadoRecepcion3 = $areaRecibe->id_jefe;

        }else{
            $encargadoRecepcion = null;
            $encargadoRecepcion2 = null;
            $encargadoRecepcion3 = null;

     }     
     $userR = Yii::$app->user->identity->id_agente;

     if($userR == $encargadoRecepcion || $userR == $encargadoRecepcion2 || $userR == $encargadoRecepcion3){
        $encargado2 = true;
     }else{
         $encargado2 =false;
     }
$estadoBien = patrimonio\parametros\PatrimonioEstadoInterno::find()->where(['fecha_baja' => null])->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
$area=  gestion_personal\models\PersonalOrganigrama::find()->all();
$seccion = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();

if (strpos($perfil, 'Administrador')== 1) {
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
} 
if (strpos($perfil, 'Agente')== 1) {
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
} 

if (strpos($perfil, 'Administrador')== 0 && strpos($perfil, 'Agente')== 0) {
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(
        ['OR',
            ['=','id_encargado',$user],
            ['=','id_encargado2',$user],
            ['=','id_jefe',$user],
       

        ])
        ->andWhere(['fecha_baja' => null])->all();
}
$disable = false;
$valor = false;

if ($model->id_estado_formulario!=1) {
    $disable4=true;
}else {
    $disable4 = false;
};

 if($model->id_estado_formulario != 1|| $model->detalles==null) {  
    $disable = true;
 }else{
    $disable = FALSE;
 }
 if($model->id_estado_formulario == 2) {   
    $disable2 = false;
 }else {
    $disable2 = true;
 }
 if (strpos($perfil, 'Auditor')== 1) {
    $disable = true;
} 

 $perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 

echo kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Información',
    ]
    ]);

Modal::begin([
    'header' => '<h2>Detalle Transferencia</h2>',
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
       

$this->title = 'Autorizacion Transferencias';
$this->params['breadcrumbs'][] = ['label' => 'Operaciones']; 
$this->params['breadcrumbs'][] = "Autorizacion Transferencias: " . $model->id; 

$accion= ['create'];    //accion create
if($model->id !=null ){
    $accion= ['update', 'id'=>$model->id];  //accion update

}

?>

<div class="_form" align='center'>
    
    <?php $form = ActiveForm::begin(['id' => 'Detalle ','action'=>$accion]); ?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

<!-- ?= $form->field($model, 'id_acta_transferencia')->hiddenInput()->label(false); ?> -->


<div class="panel panel-primary" style="width:100%;margin-left:0px;margin-right:0px">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> DATOS GENERALES DE LA TRANSFERENCIA  </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?= 
                 Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                   
                        
                            'attributes' => [ 
                           

                                'id_dependencia' => ['label' => 'Area que transfiere', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($areaTransfiere,'id','denominacion'),
                                    'pluginOptions' => ['allowClear' => true],
                                    'options' => ['disabled' => $disable4],
                                    'value'=>function($model){
                                        return $model->areaTransfiere->denominacion;
                                    },
                            ]],

                            'id_dependencia2' => ['label' => 'Area que recepciona', 'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                                'data'=>yii\helpers\ArrayHelper::map($seccion,'id','denominacion'),
                                'pluginOptions' => ['allowClear' => true],
                                'options' => ['placeholder' => 'Seleccione ',
                                'disabled' => $disable4]
                        ]],
    

                            ]

                            
                        
                ]);
                ?>


<?= 
                 Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,                        
                    'attributes' => [ 
                        'nro_acta_transferencia' => [
                            'label' => 'Nro. Acta Transferencia',
                            'type' => Form::INPUT_TEXT,                               
                            'options' => ['readOnly' => $disable4]
                                                        ], 
                            'fecha_transferencia'=>[
                                    'label'=>'Fecha de operación',
                                    // 'type'=>Form::INPUT_WIDGET, 
                                    // 'widgetClass'=> kartik\datecontrol\DateControl::class, 
                                    // 'options'=>[
                                    //     'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                                    //     'widgetOptions'=>[
                                    //         'pluginOptions' => [
                                    //             'autoclose' => true,
                                    //             'todayHighlight' => true,
                                    //             'endDate'=>'now'
                                    //         ],
                                    //     ]
                                    // ]
                                    'options' => ['readOnly' => $disable4]
                                ],

                           
                            ]
                ]);
                ?>
             <?= Form::widget([    
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>2,
                    'attributes'=>[
                        'observaciones'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'']],
                    ],
                 ]);
            ?>
            </div>
        </div>
    </div>
</div>


<div class="form-group" align="center">

<?php 
if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Encargado')== 1) {  ?>
<?=Html::submitButton('<span class="glyphicon glyphicon-check"></span> Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary', 'disabled'=>$disable4 ])?>  
<?php } ?>

</div>

<?php
ActiveForm::end();
//yii\widgets\Pjax::end();
?>

</div>
<div class="inic-espumoso-det-form">    
    <p> 
        <?php 
             $urlRegresar = "acta-transferencia-cab/index";
            
             echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-primary']);           
           
             

            if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || (strpos($perfil, 'Encargado')== 1 && $encargado==true) || (strpos($perfil, 'Jefe')== 1 && $encargado==true)) {

             if($model->id_estado_formulario==1){
                echo  '   ' . Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar bien', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['acta-transferencia-cab/create-detalle']), 'class' => 'btn btn-success']) ; 
                } else{
                 echo  '   ' . Html::button('<span class="glyphicon glyphicon-plus"></span> Agregar bien', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['acta-transferencia-cab/create-detalle']), 'disabled'=>true ,'class' => 'btn btn-success']) ; 
               }
            }
      ?>
    <?php 
    //se tomo de declaracion sin el if del idestado
    
     if ($model->id_estado_formulario==1){
         $opcion_update = function ($url,$dataProviderDetalle) {


                return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                            ['title'=>'Editar Detalle','name' => 'btEditar', 
                                            'value' => \yii\helpers\Url::to(['acta-transferencia-cab/update-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-info']);

            };

         $opcion_delete = function ($url,$dataProviderDetalle) {

               return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                            ['title'=>'Eliminar Detalle','name' => 'btEliminar',
                                            'value' => \yii\helpers\Url::to(['acta-transferencia-cab/delete-detalle','id'=>$dataProviderDetalle->id]),
                                            'class' => 'btn btn-danger']); 
           };

         }else{

         $opcion_update = function ($url,$dataProviderDetalle) {
             return ""; }   ;
         $opcion_delete =    function ($url,$dataProviderDetalle) {
                                         return "";
                                    }   ;
         }
        
           ?>
     <?php
                
                $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                           
                            ['attribute'=>'id_bien_uso',
                            'label'=>'Bien uso',
                            'value'=>function($model){
                                return $model->bienUso->strBien;
                            },
                        ],
                            ['attribute'=>'id_condicion',
                              'label'=>'Condicion',
                              'value'=>function($model){
                              return $model->condicionBien->descripcion;
                        },
                            ],
                           
                            ['attribute'=>'observaciones',
                             'label'=>'Observaciones'],
                              //traer dato de la cabecera transferencia
                             ['attribute'=>'id',
                             'label'=>'Motivo Rechazo',
                             'value'=>function($model){
                                 if($model->cabecera){
                                    return $model->cabecera->motivo_rechazo;
                                 }else{
                                    return "-";
                                }
                                 
                             
                       },
                           ],
                           ['attribute'=>'id',
                           'label'=>'Observaciones aprobado',
                           'value'=>function($model){
                               if($model->cabecera){
                                return $model->cabecera->observaciones_aprobado; 
                               }else{
                                   return "-";
                               }
                           
                     },
                         ],
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
                           'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de Transferencias</h3>',
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
                <div class="dvd">
                    <div class="producto"></div>
                    <div class="secondtable"></div>
                </div>
    <?php  
  $form = ActiveForm::begin(['id'=>'actatransferenciacab']); ?>
 <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
 <?php echo $model->id_estado_formulario == 2?Form::widget([    
                 'model'=>$model,
                 'form'=>$form,
                 'columns'=>1,
                 'attributes'=> [ 
                        'motivo_rechazo'=>['type'=>$model->id_estado_formulario > 2?Form::INPUT_STATIC:Form::INPUT_TEXTAREA],
                        
                                 
                 ],
                 
               
                  ]):'';
                  
             ?> 

    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
    <?php echo $model->id_estado_formulario== 2? 
                Form::widget([    
                 'model'=>$model,
                 'form'=>$form,
                 'columns'=>1,
                 'attributes'=>  [ 
                  'observaciones_aprobado'=>['type'=>$model->id_estado_formulario >2?Form::INPUT_STATIC:Form::INPUT_TEXTAREA],
                          
                 ],
             
                  ]):'';
                  if ($encargado==true || strpos($perfil, 'Administrador')== 1){
             ?>  
        
         <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar', ['id'=>'btPresentar','class' => 'btn btn-primary','disabled'=>$disable])?>  
         <?php }?>
         <?php if ($encargado2==true || strpos($perfil, 'Administrador')== 1){?>
         <?= Html::Button('<span class="glyphicon glyphicon-ok"></span>  Aprobar', ['id'=>'btAprobar','class' => 'btn btn-success','disabled'=>$disable2]) ?>
         <?= Html::Button('<span class="glyphicon glyphicon-remove"></span> Rechazar', ['id'=>'btRechazar','class' => 'btn btn-danger','disabled'=>$disable2]) ?>
         <?php }?>
    <?php ActiveForm::end(); ?>
    <?php 
    $url = Url::to(['acta-transferencia-cab/create-detalle']);   
    $url2 = \yii\helpers\Url::to(['acta-transferencia-cab/autorizacion-masiva']);  
    $idCab = $model->id?$model->id:"";
    $token = Yii::$app->request->getCsrfToken();
    $urlRechazar = \yii\helpers\Url::to(['rechazar','id'=>$model->id]);
    $urlAprobar = \yii\helpers\Url::to(['aprobar','id'=>$model->id]);
    $url = Url::to(['acta-transferencia-cab/datos-usuario']);
    $urlPresentar = \yii\helpers\Url::to(['presentar','id'=>$model->id]);
    $url2 = Url::to(['acta-transferencia-cab/datos-usuario2']);
    $script = <<< JS

    function traerDatosUsuario(id){
        
        if($('#actatransferenciacab-id_usuario_transferencia').val().trim()!=''){        
            //alert(id)
            $.ajax({
                type: "GET",
                url:"$url",            
                data: "id="+id,
                
                success: function (response) {     
                    var datos = jQuery.parseJSON(response);
                    var datosUsuario = datos.datos;
                    var datosError = datos.error;
                    console.log(datosUsuario)
                    console.log(id)
                    if (datosUsuario.str_departamento==" "||datosUsuario.str_seccion=="") {
                        $("#actatransferenciacab-str_departamento").val("No hay datos disponibles");
                        $("#actatransferenciacab-str_seccion").val("No hay datos disponibles");
                    }else{
                    $("#actatransferenciacab-str_departamento").val(datosUsuario.str_departamento);
                    $("#actatransferenciacab-str_seccion").val(datosUsuario.str_seccion);
                    }
                    $("#actatransferenciacab-id_departamento").val(datosUsuario.id_departamento);
                    $("#actatransferenciacab-id_seccion").val(datosUsuario.id_dependencia);
                }                
            });      
        } else {
            //alert('nada');
            krajeeDialog.alert("Error.");
            return false;           
        }    
    }            
    $("#actatransferenciacab-id_usuario_transferencia").change(function(){
        
      
        traerDatosUsuario($('#actatransferenciacab-id_usuario_transferencia').val()); 
    });
    
    $('#btnGuardar').click(function(){
        
     });   


     function traerDatosUsuario2(id){
        
        if($('#actatransferenciacab-id_usuario_recepcion').val().trim()!=''){        
            //alert(id)
            $.ajax({
                type: "GET",
                url:"$url",            
                data: "id="+id,
                
                success: function (response) {     
                    var datos = jQuery.parseJSON(response);
                    var datosUsuario = datos.datos;
                    var datosError = datos.error;
                    console.log(datosUsuario)
                    console.log(id)
                    if (datosUsuario.str_departamento==" "||datosUsuario.str_seccion=="") {
                        $("#actatransferenciacab-str_departamento2").val("No hay datos disponibles");
                        $("#actatransferenciacab-str_seccion2").val("No hay datos disponibles");
                    }else{
                    $("#actatransferenciacab-str_departamento2").val(datosUsuario.str_departamento);
                    $("#actatransferenciacab-str_seccion2").val(datosUsuario.str_seccion);
                    }
                    $("#actatransferenciacab-id_departamento2").val(datosUsuario.id_departamento);
                    $("#actatransferenciacab-id_seccion2").val(datosUsuario.id_dependencia);
                }                
            });      
        } else {
            //alert('nada');
            krajeeDialog.alert("Error.");
            return false;           
        }    
    }            
    $("#actatransferenciacab-id_usuario_recepcion").change(function(){
        
      
        traerDatosUsuario2($('#actatransferenciacab-id_usuario_recepcion').val()); 
    });
    
    $('#btnGuardar').click(function(){
        
     }); 
  

    $("#btRechazar").click(function(){
        
        
        if($.trim($("#actatransferenciacab-motivo_rechazo").val()) == ""){
            krajeeDialog.alert("¡Debe ingresar un motivo de rechazo!");
            $("#actatransferenciacab-motivo_rechazo").val("");
            return;
        }

        krajeeDialog.confirm("Esta Seguro que quiere Rechazar esta transferencia?", function (result) {
            if(result){
                $("#actatransferenciacab").attr("action","$urlRechazar").submit();
            }
        });
   });

   $("#btAprobar").click(function(){
        
        
    if($.trim($("#actatransferenciacab-observaciones_aprobado").val()) == ""){
            krajeeDialog.alert("¡Debe llenar el campo de aprobado!");
            $("#actatransferenciacab-observaciones_aprobado").val("");
            return;
        }

        krajeeDialog.confirm("Esta Seguro que quiere Aprobar esta transferencia?", function (result) {
            if(result){
                $("#actatransferenciacab").attr("action","$urlAprobar").submit();
            }
        });
   });

   $("#btPresentar").click(function(){
        krajeeDialog.confirm("Esta Seguro que quiere Presentar esta Solicitud?", function (result) {
            if(result){
                $("#actatransferenciacab").attr("action","$urlPresentar").submit();
            }
        });
   });

  
  
    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nuevo Detalle ");
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
            .load($(this).attr("value"));
           
    });
 
    $("button[name*=\'btView\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Ver detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value"));
    });
        
    $("#modalDetalle").on("hidden.bs.modal", function() {
        $("#modalContentDetalle").html("Cargando... Espere...");
    });    
    $('form').submit(function() {
        
         $("#btnGuardar").prop('disabled',true);     
   });  



JS;
$this->registerJs($script);
?>
</div>