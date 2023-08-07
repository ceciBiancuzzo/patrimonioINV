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
 if ($model->id_estado = 1 ){
            
           
            $carga_serie = function($url,$dataProviderDetalle){            //print_r($dataProviderDetalle);die();

                return "   ".Html::button('<span class="glyphicon glyphicon-plus-sign"></span>', 
                ['title'=>'Cargar número','name' => 'btCarga', 
                'value' => \yii\helpers\Url::to(['acta-recepcion-cabecera/carga-serie',
                'id'=>$dataProviderDetalle->id]),'class' => 'btn btn-info'
            ]);
<<<<<<< HEAD
            };  
                     
=======
            };               
>>>>>>> aprobacion_bodega-gerFinal
            if($model->detalles != null){
                
                // foreach($model->detalles[0] as $item){
                //     // print_r($item);
                //     // die();
                //     if($item->necesidad_aprobacion == 0){
                         
                $opcion_aprobacion = function($url,$dataProviderDetalle) {
                //print_r($dataProviderDetalle);die();
                if($dataProviderDetalle->necesidad_aprobacion == true){

                    return "   ".Html::button('<span class="glyphicon glyphicon-ok"></span>', 
                            ['title'=>'Revisión técnica','name' => 'btAprobacionTecnica',
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
            }else{
                $opcion_aprobacion = function ($url,$dataProviderDetalle){
                    return "   ".Html::button(
                        '<span class="glyphicon glyphicon-remove"></span>',
                        ['class'  => 'btn btn-info',
                        'disabled' => true]);
                        };
            }
            
                            
        }else{
           
            $carga_serie = function ($url,$dataProviderDetalle){
                return "-";
                    };
            $opcion_aprobacion = function ($url,$dataProviderDetalle){
                return "   ".Html::button(
                    '<span class="glyphicon glyphicon-remove"></span>',
                    ['class'  => 'btn btn-info',
                    'disabled' => true]);
                    };
        }
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute'=>'id_bien_uso',
                    'label'=>'Bien de Uso',
                    'value'=>function($model){
                        return $model->tipo_bien;
                    },
                ],
                [
                    'attribute'=>'id_rubro',
                    'label'=>'Rubro',
                    'value'=>function($model){
                        return $model->rubro->strRubro?$model->rubro->strRubro:"-";
                    },
                ],    
                // [
                //     'attribute'=>'Marca',
                //     'label'=>'Marca',
                //     'value'=>function($model){
                //         return $model->marcas?$model->marcas->denominacion:"-";
                //     },
                // ],    
                [
                    'attribute'=>'nro_serie',
                    'label'=>'Número de serie',
                    'value'=>function($model){
                        return $model->nro_serie?$model->nro_serie:"-";
                    },
                ],    
                [
                    'attribute'=>'Descripción del bien',
                    'label'=>'Descripción',
                    'value'=>function($model){
                        return $model->descripcion_bien?$model->descripcion_bien:"-";
                    },
                ],    
                [
                    'attribute'=>'modelo',
                    'label'=>'Modelo',
                    'value'=>function($model){
                        return $model->modelo;
                    },
                ], 
                [
                    'attribute'=>'aprobacion',
                    'label'=>'Estado aprobación',
                    'value'=>function($model){
                         if($model->aprobacion === 0){
                            return "Pendiente";
                        }
                        if($model->aprobacion === 2){
                            return "Aprobado";
                        }
                        if($model->aprobacion === 1){
                            return "Rechazado";
                        }
                        
                        //return $model->aprobacion == true ?"Aprobado":"Pendiente / Rechazado";
                    },
                ],    
                        
              
                
                ['class' => 'kartik\grid\ActionColumn',
                    'template' => ' {aprobacion-tecnica}{carga-serie}',
                    'buttons' => [
                    'aprobacion-tecnica' => $opcion_aprobacion,
                    'carga-serie' => $carga_serie,
<<<<<<< HEAD

                
=======
>>>>>>> aprobacion_bodega-gerFinal
                    ],
                ],  
            ];
    ?>  
      
                <?= GridView::widget([
                        'id'=>'gridDetalle',
                        'dataProvider' => $dataProviderBienes,
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