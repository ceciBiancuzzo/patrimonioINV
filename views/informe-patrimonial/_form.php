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
use patrimonio\parametros\PatrimonioDependencia;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
if($model->id_estado_formulario == 6 || $model->id_estado_formulario == 3){
    $disabled = true;
}else{
    $disabled =false;
}
if($model->id_estado_formulario == 3){
    $disabled2 = true;
}else{
    $disabled2 =false;
}
$user = Yii::$app->user->identity->id_agente;
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
  
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 

$marcas= patrimonio\parametros\PatrimonioMarca::find() ->orderBy(['id' => SORT_DESC])->all();
$estados= patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$condiciones = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$area= patrimonio\parametros\PatrimonioArea::find()->all();

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name 
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'Informacion',
    ]
]);
Modal::begin([
    'header' => '<h2>Acta de transferencia</h2>',
    'headerOptions' => ['id' => 'modalTransferenciaHeader'],
    'id' => 'modalTransferencia',
    'size' => 'modal-lg modal-scroll',
    'options' => [
        'tabindex' => false, // important for Select2 to work properly
        'style'=>'overflow:hidden;',
    ],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
]);
echo "<div id='modalContentTransf'>Cargando... Espere...</div>";
Modal::end();     
Modal::begin([
    'header' => '<h2>Consulta de sobrantes</h2> <br> Nota: Indique el número de inventario para conocer donde se encuentra registrado el bien conforme el sistema
    <br><br>Una vez tomado conocimiento comuniquese con el área para corregir la situación',
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

$area = PatrimonioDependencia::find()
->where(['id'=>$model->id])
->one();
$areaTitulo = $area->denominacion;
$titulo = $areaTitulo;
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['id' => 'informepatrimonial']); ?> 

<div class="inic-espumoso-cab-index" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Informe patrimonial de <?= $titulo ?></h4>
        </div>    
    </div>
    
<div class="evento-createbien">

    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

 <div class="panel panel-primary" style="width:100%">
    <div class="panel-heading">
        <h3 class="panel-title" align="center">
            <i class="glyphicon glyphicon-pencil"></i>
                BIENES REGISTRADOS EN EL AREA 
                <span>
        </span>  

        <?php
        $opcion_view_transferencia= function($url,$dataProvider){
    
                if($dataProvider->id_acta_transferencia !=null){
                    return "   ".Html::button('<span class="glyphicon glyphicon-eye-open"></span>', 
                    ['title'=>'Editar Detalle','name' => 'btEditar', 
                    'value' => \yii\helpers\Url::to(['informe-patrimonial/view-transferencia',
                    'id_acta_transferencia'=>$dataProvider->id_acta_transferencia]),
                    'class' => 'btn btn-success'
                     ]);
                };

                if($dataProvider->id_acta_transferencia==null){
                    return "   ".Html::button('<span class="glyphicon glyphicon-eye-open"></span>', 
                    [
                    'class' => 'btn btn-success',
                    'disabled'=>true
                     ]);
                
                 };

                }

                ?>

         <?php
            
            
    
            $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                    ['attribute'=>'nro_inventario','label'=>'Número de inventario','value'=>function($model){
                        return $model->nro_inventario?$model->nro_inventario:" - ";
                        },    'hAlign' => 'center',

                    ],    
                    
                    
                    ['attribute'=>'fecha_carga','label'=>'Fecha de origen',
                    'format'=>['date','php:d/m/Y'],

                    'value'=>function($model){
                        return $model?$model->fecha_carga:"-";
                        
                   },    'hAlign' => 'center',

                    ], 
                    ['attribute'=>'tipo_bien','label'=>'Tipo de bien','value'=>function($model){
                        return $model?$model->strInforme:" - ";
                        },    'hAlign' => 'center',

                    ],
                    ['attribute'=>'id_condicion','label'=>'Estado del bien','value'=>function($model){
                        return $model->id_condicion?$model->condicion->descripcion:" - ";
                        },    'hAlign' => 'center',

                    ],      
                   
                    ['attribute'=>'tipo_identificacion','label'=>'Tipo de identificación','value'=>function($model){
                        if($model->tipo_identificacion){
                            return $model->tipo_identificacion;
                        }else{
                            return "-";
                        }
                    },    'hAlign' => 'center',

                    ],
            
                    ['attribute'=>'id_usuario_bien','label'=>'Usuario asignado','value'=>function($model){
                        if($model->usuarioAsignado){
                            return $model->usuarioAsignado->strAgente;
                          }else{
                            return "-"; 
                          }
                    
                    },   'hAlign' => 'center',

                    ],
                    ['class' => '\kartik\grid\CheckboxColumn',
                    //el check solo esta disponible para las ddjj en estado borrador
                    'header' => 'Faltantes',
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        if($model->faltante==false){
                                return ['disabled' => false];
                            }else{
                                return ['disabled' => true];
                            }    
                    }
                    ],
            ];

            ?>



    </div>

    <div  class="well">
    
        <?= GridView::widget([
            'id'=>'gridInforme',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,

               'panel' => [
                   'type' => GridView::TYPE_INFO,
               ],  

               
               'exportConfig' => [

                    GridView::CSV => [
                        'label' => 'CSV',
                        'filename' => 'INIC',
                        'options' => ['title' => 'Lista de INIC'],
                    ],
                    GridView::EXCEL => [
                        'label' => 'Excel',
                        'filename' => 'INIC',
                        'options' => ['title' => 'Lista de INIC'],
                    ],            
             ],


               // set a label for default menu
               'export' => [
                   'label' => 'Pagina',
                   'fontAwesome' => true,
               ],    

               'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
               'headerRowOptions'=>['class'=>'kartik-sheet-style'],        

               'pjax'=>false, // pjax is set to always true for this demo
               'persistResize'=>false,
               'responsive'=>true,
               'hover'=>true,  
           ]); 

        ?>

                <?= FormGrid::widget([
                    'model' => $model,            

                    'form' => $form,
                    'autoGenerateColumns' => true,
                    'rows' => [
                        [
                            'attributes' => [
                                'observaciones' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Faltantes declarados por el área', 'options' => ['placeholder' => ''],'value'=>function($model){
                                    return $model->getSobrantes();
                               },],
                                'sobrantes' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Sobrantes declarados por el área', 'options' => ['placeholder' => '']],
                                'observaciones_admin' => ['type' => Form::INPUT_TEXTAREA,
                                'label'=>'Observaciones Encargado Patrimonio', 'options' => ['placeholder' => '']],
                              
                            ],
                        ],
                    ]
                ]);
                ?>
  

<?php

$attributes = [
    [
        'group'=>true,
        // 'label'=>'SECCION 1: Datos generales de transferencia',
        // 'rowOptions'=>['class'=>'table-info']
    ],
  
];




?>





<div class="form-group" align="center">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar cambios', ['id'=>'btGuardar','class' => 'btn btn-info','disabled'=>$disabled]) ?>
    <?php

 
   
     echo  '   ' . Html::button('<span class="glyphicon glyphicon-plus"></span> Declarar bienes sobrantes', 
     ['id' => 'btSobrantes','value' => \yii\helpers\Url::to(['informe-patrimonial/declarar-sobrantes','id'=>$model->id]), 'class' => 'btn btn-danger','disabled'=>$disabled]) ; 
    ?>
            <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar informe', ['id'=>'btPresentar','class' => 'btn btn-warning','disabled'=>$disabled]) ?>

  
    <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Declarar bienes faltantes', ['id'=>'btFaltantes','class' => 'btn btn-primary','disabled'=>$disabled]) ?>

    </div class="btn-regresar" align="left">
    <?php
     $urlRegresar = "informe-patrimonial/index";
     echo Html::a( '<span class="glyphicon glyphicon-chevron-left"></span> Regresar', [$urlRegresar],['id' => 'btRegresar', 'class' => 'btn btn-primary']); 

    ?>
    <div>
    </div>
   
   <?php ActiveForm::end(); ?>

</div>


<div class="form-group" align="center">

<?php if (strpos($perfil, 'Administrador')== 1 ){ ?>

<?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Volver a estado borrador', ['id'=>'btBorrador','class' => 'btn btn-warning','disabled'=>$disabled2]) ?>

<?php 
}
?>

    <?php if (strpos($perfil, 'Administrador')== 1 ){ ?>

<?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Aprobar', ['id'=>'btAprobar','class' => 'btn btn-success','disabled'=>$disabled2]) ?>

  <?php 
  }
  ?>
 

   
</div>


<?php

$url = \yii\helpers\Url::to(['informe-patrimonial/autorizacion-masiva']) ;
$urlFaltantes = \yii\helpers\Url::to(['informe-patrimonial/faltantes']) ;
$urlAprobar = \yii\helpers\Url::to(['informe-patrimonial/aprobar']) ;
$urlBorrador = \yii\helpers\Url::to(['informe-patrimonial/volver-borrador']) ;
$urlGuardarCambios = \yii\helpers\Url::to(['informe-patrimonial/update']) ;
$token = Yii::$app->request->getCsrfToken();

// echo "<pre>";
// print_r($dataProvider);
// echo "</pre>";
// ${exit()};
foreach($dataProvider->models as $id_acta){
$idCab = $id_acta->id_acta_transferencia;
}

// echo "<pre>";
// print_r($idCab);
// echo "</pre>";
// ${exit()};
$script = <<< JS
  
$("#btSobrantes").click(function(){
        $("#modalDetalleHeader").find("h2").html("Consulta de sobrantes");
        $("#modalDetalle").modal("show")
            .find("#modalContentDetalle")
          
            .load($(this).attr("value"));

    });
$("button[name*=\'btEditar\']").click(function(){
    $("#modalTransferenciaHeader").find("h2").html("Ver transferencia");   
    $("#modalTransferencia").modal("show")
        .find("#modalContentTransf")
        .load($(this).attr("value"));
});
$("#btPresentar").click(function(){
        krajeeDialog.confirm("Esta seguro/a que quiere presentar este informe?", function (result) {
            if(result){
                $("#informepatrimonial").attr("action","$url").submit();
            }
        });
   });
$("#btAprobar").click(function(){
        krajeeDialog.confirm("Esta seguro/a que quiere aprobar este informe?", function (result) {
            if(result){
                $("#informepatrimonial").attr("action","$urlAprobar").submit();
            }
        });
});
$("#btBorrador").click(function(){
        krajeeDialog.confirm("Esta seguro/a que quiere aprobar este informe?", function (result) {
            if(result){
                $("#informepatrimonial").attr("action","$urlBorrador").submit();
            }
        });
});
$('#btnGuardar').click(function(){
    krajeeDialog.confirm("Esta seguro/a que quiere aprobar este informe?", function (result) {
            if(result){
                $("#informepatrimonial").attr("action","$urlGuardarCambios").submit();
            }
        });
});

$('#btFaltantes').click(function(){
    krajeeDialog.confirm("¿Esta seguro/a que desea declarar faltante estos bienes?", function (result) {
    if (result) { // ok button was pressed
       
        var keys = $('#gridInforme').yiiGridView('getSelectedRows');
        if(keys != ''){
         //console.log(keys);
           $.ajax({
                url: '$urlFaltantes',
                type: 'post',
                data: {
                         
                           ids: keys, 
                          _csrf : '$token'
                      },
                success: function (data) {
                    //console.log(data);
                   // var obj = jQuery.parseJSON(data);
                    if(data){
                        $("#gridInforme").yiiGridView("applyFilter");
                        krajeeDialog.alert("Los faltantes fueron declarados correctamente");

                    }
                }
           });
        }else{
            krajeeDialog.alert("Debe seleccionar al menos un bien");
        }
    } else { // confirmation was cancelled
        krajeeDialog.alert("Se cancelo la declaración");
        
    }
});
});
JS;
$this->registerJs($script);
//yii\widgets\Pjax::end();
?>