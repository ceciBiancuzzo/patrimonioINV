<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\DateControl\DateControl;
use kartik\export\ExportMenu;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use gestion_personal\models\PersonalAgente;


$titulo = 'Acta de Recepción';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    foreach ($busco_perfiles[17] as $roles){      
        $perfil = $perfil . '-' . $roles;
    } 

$user = Yii::$app->user->identity->id_agente;
$dependencia = PersonalAgente::find()
->where(['legajo' => $user])
->one();
$areaInformatica=null;
$areaLaboratorio=null;
if($dependencia->id_seccion == 2030 || $dependencia->id_seccion == 2033 || $dependencia->id_seccion == 2035){
    // if($dataProvider->detalles->id_area_tecnica == 2030){
    //     $areaInformatica =true;
    // }
}
if($dependencia->id_seccion == 1012 || $dependencia->id_seccion == 1022 || $dependencia->id_seccion == 1032 || $dependencia->id_seccion == 1062 ||
$dependencia->id_seccion == 1072 || $dependencia->id_seccion == 1092 || $dependencia->id_seccion == 1102 || $dependencia->id_seccion == 1112 || $dependencia->id_seccion == 1146){
    $areaLaboratorio = true;
}



?>
<div class="acta-recepcion-cabecera-index" >
    
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Consulta de <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>

    
    <?php
        // echo "<pre>";
        // print_r($dataProvider);
        // echo "</pre>";
        // die();
        $opcion_update =  function ($url,$model) {
          //  print_r($model->detalles);die();
           //e if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || (strpos($perfil, 'Jefe')== 1 && $model->detalles->id_area_tecnica == $dependencia->seccion){
            if($model->id_estado >=2 ){
                return "   ".Html::a(
                    '   <span class="glyphicon glyphicon-eye-open"></span>',
                    $url, 
                    [
                        'title' => 'Ver'
                    ]
                );
            } 
            if($model->id_estado ==1||$model->id_estado==null ) {
                return "   ".Html::a(
                    '  <span class="glyphicon glyphicon-pencil"> </span>',
                    $url, 
                    [
                        'title' => 'Editar'
                    ]
                );  
            }                                
        };
                 
        $gridColumns = [
<<<<<<< HEAD
=======
            
>>>>>>> aprobacion_bodega-gerFinal
            [
                'attribute'=>'nro_acta',
                'label'=>'Numero de Acta',
            ],
            [
                'attribute'=>'id',
                'label'=>'Dependencia',
                'value'=>function($model){
                    if ($model->seccion) {
                        return $model->seccion->strDependencia;
                    }
                else{
                    return '-';
                }
            }
            ],        
            [
                'attribute'=>'orden_compra',
                'label'=> 'Orden de Compra'
            ],
            [
                'attribute'=>'fecha_acta',
                'label'=>'Fecha de Acta'
            ],
          
           
<<<<<<< HEAD
           
=======
>>>>>>> aprobacion_bodega-gerFinal
            ['class' => '\kartik\grid\CheckboxColumn',
            //el check solo esta disponible para las ddjj en estado borrador
            'header' => 'Presentar',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                if ($model->id_estado == 1){
                        return ['disabled' => false];
                    } else{
                        return ['disabled' => true];

                    }
                }
            ],
            [
                'attribute'=>'id_estado',
                'label'=>'Estado',
                'value'=>function($model){
                    if($model->id_estado == 1){ 
                        return "Borrador";
                    }else if($model->id_estado == 2){
                            return "Pendiente";
                            }else if ($model->id_estado == 3){
                                return "Aprobado";
                                    }else if ($model->id_estado == 4){
                                        return "Rechazado";

                    }  
                }
            ], 
            ['class' => 'kartik\grid\ActionColumn',
            'template' => ' {update}{print}{delete}',
            'buttons' => [
                'update'=>$opcion_update,
                'print' => function ($url,$searchModel) {
                    return "   ".Html::a(
                        '<span class="glyphicon glyphicon-print"></span>',
                        $url, 
                        [
                            'title' => 'Imprimir',
                            'target'=>'_blank'
                        ]
                    );
                }, 
                'delete' => function ($url,$searchModel) {
                    return "   ".Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                            $url, 
                            [
                                'title' => 'Eliminar',
                                'data'=>[
                                    'confirm'=>Yii::t('app', '¿Está seguro que desea eliminar esta transferencia?'),
                                    'method'=>'post',
                            ], 
                        ]
                    );
                },                   
            ], 
            ]
        ];           
    ?>

<?php  

if (strpos($perfil, 'Jefe') == 1){ ?>
    <?php  
  
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            
            [
                'attribute'=>'str_seccion',
                'label'=>'Seccion',
                'value'=>function($model){
                    if ($model->seccion) {
                        return $model->seccion->denominacion;
                    }
                else{
                    return '-';
                }
            }
            ],        
            [
                'attribute'=>'orden_compra',
                'label'=> 'Orden de Compra'
            ],
            [
                'attribute'=>'fecha_acta',
                'label'=>'Fecha de Acta'
            ],
          
            [
                'attribute'=>'nro_acta',
                'label'=>'Numero de Acta',
            ],
            [
                'attribute'=>'id_estado',
                'label'=>'Estado',
                'value'=>function($model){
                    if($model->id_estado == 1){ 
                        return "Borrador";
                    }else if($model->id_estado == 2){
                            return "Pendiente";
                            }else if ($model->id_estado == 3){
                                return "Aprobado";
                                    }else if ($model->id_estado == 4){
                                        return "Rechazado";

                    }  
                }
            ], 
            ['class' => 'kartik\grid\ActionColumn',
            'template' => ' {update}{print}',
            'buttons' => [
                'update'=>$opcion_update,
                'print' => function ($url,$searchModel) {
                    return "   ".Html::a(
                        '<span class="glyphicon glyphicon-print"></span>',
                        $url, 
                        [
                            'title' => 'Imprimir',
                            'target'=>'_blank'
                        ]
                    );
                },           
            ], 
            ]
        ];
    
        ?>
    <?php } ?>

<?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Operario')== 1){
  ?>

    <div class="form-group" align="right">
        <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar',['id'=>'btAutorizacion','class'=> 'btn btn-success']) ?>
    </div>

    <?php } ?>

    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridAutorizacion',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'panel' => [
                'type' => GridView::TYPE_INFO,
                'heading' => '<h3 class="panel-title text-center"><i class="glyphicon glyphicon-inbox"> </i> Lista de Actas</h3>',
            ],  
            'pager' => [
                'firstPageLabel' => 'Primera',
                'lastPageLabel' => 'Ultima',
            ],
            'toolbar' =>  [ 
                ['content'=>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Resetear Grilla'])
                ],
                '{toggleData}'
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
            'rowOptions' => function($model, $key, $index, $grid){
            }, 
           ]); 
        ?>
    </div>  
</div>

<?php 
$url = \yii\helpers\Url::to(['acta-recepcion-cabecera/autorizacion-masiva']) ;
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS

$('#btAutorizacion').click(function(){
krajeeDialog.confirm("¿Desea presentar este Acta de Recepcion?", function (result) {
    if (result) { // ok button was pressed
        var keys = $('#gridAutorizacion').yiiGridView('getSelectedRows');
         console.log(keys);
           $.ajax({
                url: '$url',
                type: 'post',
                data: {
                          ids: keys, 
                          _csrf : '$token'
                      },
                success: function (data) {
                    console.log(data);
                   // var obj = jQuery.parseJSON(data);
                    if(data){
                        $("#gridAutorizacion").yiiGridView("applyFilter");
                    }
                }
           });
           window.location.alert();
    } else { // confirmation was cancelled
        krajeeDialog.alert("Se cancelo la presentacion de Acta de Recepcion");
        
    }
});
});

JS;

    $this->registerJs($script);
?>