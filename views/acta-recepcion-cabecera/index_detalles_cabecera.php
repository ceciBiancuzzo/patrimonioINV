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
//use kartik\Form\ActiveForm;
use patrimonio\parametros\Proveedor;

use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\models\ActaRecepcionDetalle;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use gestion_personal\models\PersonalOrganigrama;

$seccion= patrimonio\parametros\PatrimonioDependencia::find()->all();
$condicion = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$formaAdquisicion = patrimonio\parametros\PatrimonioFormaAdquisicion::find()->all();
$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
<<<<<<< HEAD
=======

>>>>>>> aprobacion_bodega-gerFinal
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
        'style'=>'overflow:hidden;',
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
    'header' => '<h2>Carga de archivo</h2>',
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
if ($model->id_estado==3) {
    $disable3=true;
}else{
    $disable3=false;
}
<<<<<<< HEAD
 if ($model->id_estado == 3 || $model->id_estado == 2 || $model->id_estado == 1 ){
            
=======
if ($model->id_estado == 3 || $model->id_estado == 2 || $model->id_estado == 1 ){            
>>>>>>> aprobacion_bodega-gerFinal
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
            $upload_file = function ($url,$dataProviderDetalle) {
                return "   ".Html::button('<span class="glyphicon glyphicon-open"></span>', 
                                          ['title'=>'Carga de archivo','name' => 'btCargaArchivo',
                                          'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/upload-file','id'=>$dataProviderDetalle->id]),
                                          'class' => 'btn btn-warning']); 
            };
           
            if($model->detalles != null){
                
                // foreach($model->detalles[0] as $item){
                //     // print_r($item);
                //     // die();
                //     if($item->necesidad_aprobacion == 0){
                         
                $view_file = function($url,$dataProviderDetalle) {
                //print_r($dataProviderDetalle);die();
                if($dataProviderDetalle->archivo != null){

                    return "   ".Html::button('<span class="glyphicon glyphicon-file"></span>',
                            ['title'=>'Ver archivo garantía',
                            'id'=>'btPrint',
                            'class' => 'btn btn-success',
                            'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/view-file','id'=>$dataProviderDetalle->id]),
                            'target'=>'_blank']
                        ); 
                        };
                        if($dataProviderDetalle->necesidad_aprobacion != true){
                            return "   ".Html::button(
                                '<span class="glyphicon glyphicon-file"></span>',
                                ['class'  => 'btn btn-success',
                                'disabled' => true]);
                  
                        }
                    };
            }else{
                $view_file = function ($url,$dataProviderDetalle){
                    return "   ".Html::button(
                        '<span class="glyphicon glyphicon-file"></span>',
                        ['class'  => 'btn btn-success',
                        'disabled' => true]);
                        };
            }
            
<<<<<<< HEAD
           
=======

>>>>>>> aprobacion_bodega-gerFinal
            // if($model->detalles != null){
                // foreach($model->detalles[0] as $item){
                //     print_r($item);
                //     die();
                //     if($item->necesidad_aprobacion == 0){
                         
            // $opcion_aprobacion = function ($url,$dataProviderDetalle) {
            //     if($dataProviderDetalle->necesidad_aprobacion == true){
            //         return "   ".Html::button('<span class="glyphicon glyphicon-ok"></span>', 
            //                 ['title'=>'Aprobación técnica','name' => 'btAprobacionTecnica',
            //                 'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/aprobacion-tecnica',
            //                 'id'=>$dataProviderDetalle->id]),
            //                 'class' => 'btn btn-warning']); 
            //             };
            //             if($dataProviderDetalle->necesidad_aprobacion != true){
            //                 return "   ".Html::button(
            //                     '<span class="glyphicon glyphicon-remove"></span>',
            //                     ['class'  => 'btn btn-info',
            //                     'disabled' => true]);
                  
            //             }
            //         };
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
<<<<<<< HEAD
                $upload_file =    function ($url,$dataProviderDetalle){
                    return "";
                        };
           $view_file =    function ($url,$dataProviderDetalle){
            return "";
                };
=======
            $upload_file =    function ($url,$dataProviderDetalle){
            return "";
                };
           $view_file =    function ($url,$dataProviderDetalle){
            return "";
                };

>>>>>>> aprobacion_bodega-gerFinal
        }
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute'=>'id_bien_uso',
                    'label'=>'Bien de Uso',
                    'value'=>function($model){
                        if ($model->bienUso) {
                        return $model->bienUso->tipo_bien;
                        }else{
                        return '-';
                        }
                    }
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
<<<<<<< HEAD
                    'template' => ' {update}{delete}{aprobacion-tecnica}{carga-serie}{upload-file}{view-file}',
=======
                'template' => ' {update}{delete}{aprobacion-tecnica}{carga-serie}{upload-file}{view-file}',
>>>>>>> aprobacion_bodega-gerFinal
                    'buttons' => [
                    'update' => $opcion_update, 
                    'delete' => $opcion_delete,
                    'upload-file' => $upload_file,
                    'view-file'=>$view_file,
<<<<<<< HEAD
=======

                    //'aprobacion-tecnica' => $opcion_aprobacion,
                    
>>>>>>> aprobacion_bodega-gerFinal
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
                ?>