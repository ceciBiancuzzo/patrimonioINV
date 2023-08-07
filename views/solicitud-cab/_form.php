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
use kartik\datecontrol\DateControl;
use gestion_personal\models\PersonalAgente;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\EspumanteMovimientosInternosSearch */
/* @var $form yii\widgets\ActiveForm 
*/


$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$areas= patrimonio\parametros\PatrimonioArea::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();


?>

<div class="evento-createsoli">

<?php $form = ActiveForm::begin(['id' => 'registro_solicitud']);?> 


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
    
    
  //  /crear solicitud/
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            'id_usuario_solicitante'=> [
                'label' => 'Usuario',
                'id' => 'id_usuario_solicitante',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($usuario, 'id', 'strAgente'), 'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione  Nombre y Apellido',]
                ] 
            ],

            
            'str_departamento'=> [
                'label' => 'Departamento',
                'type' => Form::INPUT_TEXT,
                'options' => ['readOnly' => true]
                //metodo para ingresar la delgacion manualmente
                /* 
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'id_delegacion',
                'options' => [
                    'data'=>yii\helpers\ArrayHelper::map($delegaciones, 'id', 'descripcion_delegacion'),
                    'options' => [
                        'placeholder' => 'Seleccione Delegacion',
                    ]
                ] */
            ],
            
            'str_seccion'=> [
                'label' => 'Seccion',
                'type' => Form::INPUT_TEXT,
                'options' => ['readOnly' => true]
                //metodo para ingresar el area manualmente 
                /* 'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'id_area_solicitante',
                'options' => [
                    'data'=>yii\helpers\ArrayHelper::map($areas, 'id', 'denominacion'),
                    'options' => [
                        'placeholder' => 'Seleccione Area',
                    ]
                ] */
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
                    'data' => yii\helpers\ArrayHelper::map($tipoSolicitud, 'id','descripcion')],
                ],
                
            'fecha_solicitud'=>[
                'label'=>'Fecha de solicitud',
                'type'=>Form::INPUT_WIDGET, 
                'widgetClass'=> kartik\datecontrol\DateControl::class, 
                'options'=>[
                    'type'=>  kartik\datecontrol\DateControl::FORMAT_DATE,
                    'widgetOptions'=>[
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'startDate'=>'now',
                            //'endDate'=>'+7d'
                        ],

                    ]
                ]      
                    ],
                    'id_seccion'=>['label'=>false,'type'=>Form::INPUT_HIDDEN, 'options'=>[]],
                    'id_departamento'=>['label'=>false,'type'=>Form::INPUT_HIDDEN, 'options'=>[]],

        ],
        
    ]);
        
        ?> 
    </div>
</div>  
<div class="form-group">
            <?php 
            $urlRegresar = "solicitud-cab/index";
            echo Html::a('<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id'=> 'btRegresar', 'class'=> 'btn btn-primary']);
            ?>
            <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Crear Solicitud', ['id' =>'btnCrearActa','class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>

<?php
$url = Url::to(['solicitud-cab/datos-usuario']);
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS

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
                    console.log(datosUsuario)
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
//yii\widge
?>