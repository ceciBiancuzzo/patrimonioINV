<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\dialog\Dialog;
use kartik\builder\FormGrid;
use yii\helpers\Url;
use kartik\bs5dropdown\ButtonDropdown;
use common\models\User;
$user = Yii::$app->user->identity->id_agente;
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
  
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 
// print_r($seccion); die();
if (strpos($perfil, 'Administrador')== 1) {
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
} 
if (strpos($perfil, 'Administrador')== 0) {
    $areaTransfiere = patrimonio\parametros\PatrimonioDependencia::find()->where(
        ['OR',
            ['=','id_encargado',$user],
            ['=','id_encargado2',$user],
            ['=','id_jefe',$user]
        ])
        ->andWhere(['fecha_baja' => null])->all();
}
$estadoBien = patrimonio\parametros\PatrimonioEstadoInterno::find()->where(['fecha_baja' => null])->all();
$condicionBien = patrimonio\parametros\PatrimonioCondicionBien::find()->where(['fecha_baja' => null])->all();
$tipoBien = patrimonio\models\BienUso::find()->where(['fecha_baja' => null])->all();
$usuario= gestion_personal\models\PersonalAgente::find()->where(['estado'=>'A'])->all();
$tipoSolicitud = patrimonio\parametros\ParametrosTipoSolicitud::find()->all();
$area = gestion_personal\models\PersonalOrganigrama::find()->all();
if (strpos($perfil, 'Administrador')== 1) {
    $seccion = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->all();
} 
if (strpos($perfil, 'Administrador')== 0) {
    $seccion = patrimonio\parametros\PatrimonioDependencia::find()->where(['fecha_baja' => null])->andWhere(['NOT IN','id', [154,183]])->all();
}
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){       
        $perfil = $perfil . '-' . $roles;
    } 
    $titulo = 'Nueva Trasferencia';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Encargado')== 1 || strpos($perfil, 'Jefe')== 1){
  ?>

<div class="evento-createacta">
<?php $form = ActiveForm::begin(['id' => 'Nueva_transferencia']); ?>
    <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
            Nueva Transferencia
        </h3>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div>
                <?=


                 Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [

                           
                                // 'id_seccion' => ['label' => 'Area que Transfiere', 'type' => Form::INPUT_WIDGET, 'pluginOptions' => ['allowClear' => true,
                                // 'readOnly' => true],
                                // 'widgetClass' => '\kartik\widgets\Select2',
                                // 'options' => [
                                //     'data'=>yii\helpers\ArrayHelper::map($areaTransfiere,'cod_desempenio','desc_desempenio'),
                                //     'options' => ['disabled' => true]
                                //     ]        
                                // ],

                          
                    'id_dependencia' => ['label' => 'Area que Transfiere', 'type' => Form::INPUT_WIDGET, 'pluginOptions' => ['allowClear' => true,
                    'readOnly' => true],
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'data'=>yii\helpers\ArrayHelper::map($areaTransfiere,'id','denominacion'),
                        'options' => ['placeholder' => 'Seleccione area que trasfiere',]
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
                           
                                'id_dependencia2' => ['label' => 'Area que Recepciona', 'type' => Form::INPUT_WIDGET, 
                                'widgetClass' => '\kartik\widgets\Select2',
                                'options' => [
                                    'data'=>yii\helpers\ArrayHelper::map($seccion,'id','denominacion'),
                                    'pluginOptions' => ['allowClear' => true],
                                    'options' => ['placeholder' => 'Seleccione area que recepciona',]
                                ]],
                    ]

                ]);
                ?>
<?=




                Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 3,


           'attributes' => [

            'tipo_solicitud' => [
                'label' => 'Tipo Solicitud',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => '\kartik\widgets\Select2',
                'id' => 'Usuario Recepciona',
                'options' => [
                    'data' => yii\helpers\ArrayHelper::map($tipoSolicitud, 'id','descripcion'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Seleccione ',]
                
                ],
                ],
                ]

            ]);
?>


               
        </div>
</div>

<div class="evento-createsoli">
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
                                'observaciones' => [
                                    'label' => 'Observaciones',
                                    'type' => Form::INPUT_TEXTAREA,
                                    'id' => 'observaciones',
                                    'options' => [
                                        'placeholder'=> '',
                                    'rows' => '5',

                                    ],
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
        $urlRegresar = "acta-transferencia-cab/index";
        echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-info']);
        ?>
     <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> Crear Transferencia', ['id' => 'btnGuardar', 'class' => 'btn btn-primary']) ;?>
    </div>
    <div class="form-group" align="left">
        
    <?php
        ActiveForm::end();
    ?>
    <?php } ?>

<?php
$url = Url::to(['acta-transferencia-cab/datos-usuario']);
$url2 = Url::to(['acta-transferencia-cab/datos-usuario2']);
$token = Yii::$app->request->getCsrfToken();

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
                    //console.log(datosUsuario)
                    //console.log(id)
                    if (datosUsuario.str_departamento==" "||datosUsuario.str_seccion=="") {
                        $("#actatransferenciacab-str_seccion").val("No hay datos disponibles");
                        $("#actatransferenciacab-str_departamento").val("No hay datos disponibles");
                       
                    }else{
                    $("#actatransferenciacab-str_seccion").val(datosUsuario.str_seccion);
                    $("#actatransferenciacab-str_departamento").val(datosUsuario.str_departamento);
                 
                    }
                    $("#actatransferenciacab-id_seccion").val(datosUsuario.id_seccion);
                    $("#actatransferenciacab-id_departamento").val(datosUsuario.id_departamento);
                  
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
                    //console.log(datosUsuario)
                    //console.log(id)
                    if (datosUsuario.str_departamento==" "||datosUsuario.str_seccion=="") {
                        $("#actatransferenciacab-str_departamento2").val("No hay datos disponibles");
                        $("#actatransferenciacab-str_seccion2").val("No hay datos disponibles");
                    }else{
                    $("#actatransferenciacab-str_departamento2").val(datosUsuario.str_departamento);
                    $("#actatransferenciacab-str_seccion2").val(datosUsuario.str_seccion);
                    }
                    $("#actatransferenciacab-id_departamento2").val(datosUsuario.id_departamento);
                    $("#actatransferenciacab-id_seccion2").val(datosUsuario.id_seccion);
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

JS;
$this->registerJs($script);
//yii\widgets\Pjax::end();
?>
</div>
