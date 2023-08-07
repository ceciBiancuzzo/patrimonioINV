<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use aprobacion_ddjj\models\ParametrosInscriptos;
use aprobacion_ddjj\models\CosechaParteSemanalCab;

$inscripto = ParametrosInscriptos::find()->one($model->getAttribute('id_nroins'));
// $ultimoParte = CosechaParteSemanalCab::find()->one($model->getAttribute('id_nroins_bodega'));
//                         // ->andWhere(['ano_elaboracion' => date('Y')])
//                         // ->orderBy(['fecha_presentacion' => SORT_DESC]);

/* @var $this yii\web\View */
/* @var $model frontend\models\InicEspumosoCab */
/* @var $form yii\widgets\ActiveForm */
$disable = false;
$valor = false;
if ($model->estado == 1) {
    $disable = true;
} else {
    $disable = FALSE;
}
echo kartik\dialog\Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Información',
    ]
    ]);

Modal::begin([
    'header' => '<h2>Detalle</h2>',
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
       

$this->title = 'Autorizacion presentacion CIU';
$this->params['breadcrumbs'][] = ['label' => 'Operaciones']; 
$this->params['breadcrumbs'][] = "Autorizacion ID: " . $model->id; 

?>
       

<div class="form_cabecera" align='center'>
    
    <?php $form = ActiveForm::begin(['id' => 'nueva_autorizacion','action'=>['create-cabecera']]); ?> 
<?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'id_nroins')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'id_establecimiento')->hiddenInput()->label(false); ?>

<div class="panel panel-primary" style="width:90%;margin-left:50px;">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> DATOS DE ESTABLECIMIENTO AUTORIZADO </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <?= FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                'strNroinscripto' => ['label' => 'Inscripto ', 'type' => Form::INPUT_TEXT, 
                                'options' => ['readOnly' => true,'value' => $inscripto->nroins, 'placeholder' => '']],
                             
                                'strTipoEstablecimiento' => [
                                    'label' => 'Establecimiento',
                                    'type' => Form::INPUT_TEXT,
                                    'options' => ['readOnly' => true,'value' => $inscripto->strTipoEstablecimiento]
                                ],
                                'razon_social_nroins' => [
                                    'label' => 'Razon social del receptor',
                                    'type' => Form::INPUT_TEXT,
                                    'options' => ['readOnly' => true]
                                ],
                                
                                'strUltimoParte' => [
                                    'label'=>'Ultimo parte',
                                    'type'=>Form::INPUT_TEXT,
                                    'options' => ['readOnly' => true, 'value'=> $model->ultimo_parte==true?'Presentado':'No presentado']
                                ],
                        ]
                        ]
                    
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-2"></div>
        </div>
    </div>
</div>

<div class="panel panel-primary" style="width:90%;margin-left:50px;">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> DATOS AUTORIZACION </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <?= FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                
                                'fecha_autorizada_presentacion' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => 'kartik\widgets\DatePicker',
                                    'useWithClass' => true,
                                    'convertFormat' => true,
                                    'label' => 'Fecha de autorizacion',
                                    'options' => [
                                        'readonly' => ($model->estado == 0) ? false : true,
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd-mm-yyyy',
                                            'startDate' => 'now',
                                            'endDate'=>'+7d'
                                        
                                            
                                        
            
                                        ],
                                    ],
                                    ['placeholder' => 'Periodo']
                                ],
                                
                
                            'antecedente_administrativo' => ['type' => Form::INPUT_TEXT,
                                                'options' => [
                                                'readonly' => ($model->estado == 0) ? false : true,
                                                ],
                                            ],
                            'ultimo_parte' =>  [
                                'type' => Form::INPUT_CHECKBOX,
                                'label' => 'Quitar marca del ultimo parte',
                
                                
                            ]
                
                            ]
                        ],
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-2"></div>
            </div>
        </div>
        </div>

<div class="panel panel-primary" style="width:90%;margin-left:50px;">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> OTROS DATOS </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <?= FormGrid::widget([
                    'model' => $model,
                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                'observaciones' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => ''],
                                'options' => [
                                    'readonly' => ($model->estado == 0) ? false : true,
                                    ],
                            ],
                            ]
                        ],
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-2"></div>
        </div>
    </div>
</div>

<div class="form-group" align="center">

<!-- ?= Html::submitButton('Guardar', ['id' => 'btnGuardar', 'disabled'=>true, 'class' => 'btn btn-primary'])?> -->
  <?= !$disable?Html::submitButton('Guardar', ['id' => 'btnGuardar', 'class' => 'btn btn-primary']):Html::submitButton('Guardar', ['id' => 'btnGuardar', 'disabled'=>true, 'class' => 'btn btn-primary']) ?> 
   


</div>

<?php
ActiveForm::end();
//yii\widgets\Pjax::end();
?>

</div>
<div class="inic-espumoso-det-form">    
    <p> 
        <?php 
            $urlRegresar = "cosecha-autoriza-ciu-cab/index";
            
            echo Html::a( 'Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-info']);           
            echo  '   ' . Html::a('Imprimir',['print','id'=>$model->id],['target'=>'_blank','id' => 'btPrint','class' => 'btn btn-warning']) ; 
            if($model->estado==0){
            echo  '   ' . Html::button('Agregar CIU autorizado', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['cosecha-autoriza-ciu-cab/create-detalle']), 'class' => 'btn btn-success']) ; 
           } else{
            echo  '   ' . Html::button('Agregar CIU autorizado', ['id' => 'btNuevo','value' => \yii\helpers\Url::to(['cosecha-autoriza-ciu-cab/create-detalle']), 'disabled'=>true ,'class' => 'btn btn-success']) ; 
           }
           // echo  '   ' . Html::button('Nuevo detalle', ['id' => 'btNuevoDetalle','value' => \yii\helpers\Url::to(['espumante-exportacion-cab/create-detalle']), 'class' => 'btn btn-success']) ;
      ?>
    <?php 
    //se tomo de declaracion sin el if del idestado
    
    if ($model->estado == 0 ){
        $opcion_update = function ($url,$dataProviderDetalle) {


               return "   ".Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
                                           ['title'=>'Editar Detalle','name' => 'btEditar', 
                                           'value' => \yii\helpers\Url::to(['cosecha-autoriza-ciu-cab/create-detalle']).'?id='.$dataProviderDetalle->id, 
                                           'class' => 'btn btn-info']);

           };

        $opcion_delete = function ($url,$dataProviderDetalle) {

               return "   ".Html::button('<span class="glyphicon glyphicon-trash"></span>', 
                                           ['title'=>'Eliminar Detalle','name' => 'btEliminar',
                                            'value' => \yii\helpers\Url::to(['cosecha-autoriza-ciu-cab/delete-detalle']).'?id='.$dataProviderDetalle->id, 
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
                            ['attribute'=>'id','label'=>'ID'/*,'options' => [ 'style' => 'background-color:#DFF0D8'],*/],
                            ['attribute'=>'numero_ciu','label'=>'CIU'],
                            ['attribute'=>'fecha_alta','label'=>'Fecha de alta'],
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
                           'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de CIU</h3>',
                        ],  
                        'toolbar' =>  [
                            '{toggleData}',
                        ],        
                        'responsive' => true,
                        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
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
                ]);?>
                <div class="dvd">
                    <div class="producto"></div>
                    <div class="secondtable"></div>
                </div>
<?php  

$url = Url::to(['cosecha-autoriza-ciu-cab/datos-inscripto']);     
$idCab = $model->id?$model->id:"";
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
    function traerDatosInscripto(nroins){
        //alert(nroins);
        if($('#cosechaautorizaciucab-strnroinscripto').val().trim()!=''){        
            $.ajax({
                type: "GET",
                url:"$url",
                data: "strNroinscripto="+nroins,
                success: function (response) {     
                    var datos = jQuery.parseJSON(response);
                    var datosInscripto = datos.datos;
                    var datosError = datos.error;
                   /*  if(datosError!=''){
                        alert("El inscripto indicado no existe, por favor verifique");
                        return false;
                    }
                    if(datosInscripto.strTipoEstablecimiento != 2 && datosInscripto.strTipoEstablecimiento != 12){ 
                        alert("El tipo de establecimiento no se encuentra habilitado");
                        return false;
                    }   */
                    $("#cosechaautorizaciucab-razon_social_nroins").val(datosInscripto.nombre);
                    $("#cosechaautorizaciucab-strtipoestablecimiento").val(datosInscripto.strTipoEstablecimiento);
                    $("#cosechaautorizaciucab-id_nroins").val(datosInscripto.id_nroins);
                    $("#cosechaautorizaciucab-id_establecimiento").val(datosInscripto.id_establecimiento);
                    $("#cosechaautorizaciucab-id_delegacion").val(datosInscripto.id_delegacion);
                    $("#cosechaautorizaciucab-ultimo_parte").val(datosInscripto.cerrado);
                    $("#cosechaautorizaciucab-strultimoparte").val(datosInscripto.cerrado == true?'Presentado':'No presentado');
                    // $('#cosechaautorizaciucab-razon_social_nroins').prop('disabled',true);
                    // $('#cosechaautorizaciucab-strtipoestablecimiento').prop('disabled',true);                   
                }                
            });      
        } else {
            //alert('nada');
            krajeeDialog.alert("Indique el nro de inscripto del depositario.");
            return false;           
        }    
    } 
    $("#cosechaautorizaciucab-strnroinscripto").blur(function(){
        traerDatosInscripto($('#cosechaautorizaciucab-strnroinscripto').val()); 
    }); 
    $("#btNuevo").click(function(){
        $("#modalDetalleHeader").find("h2").html("Nuevo CIU");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load('create-detalle?id_cab=$idCab');
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
 
    $("button[name*=\'btView\']").click(function(){
        $("#modalDetalleHeader").find("h2").html("Ver detalle");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
            .load($(this).attr("value")+'&id_cab=$idCab');
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
</div>
