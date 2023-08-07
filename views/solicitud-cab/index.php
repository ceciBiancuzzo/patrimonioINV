<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use kartik\datecontrol\DateControl;
//use patrimonio\parametros\PatrimonioArea;
use gestion_personal\models\PersonalAgente;
//use parametros\models\ParametrosDelegaciones;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use patrimonio\parametros\ParametrosTipoSolicitud;
//use common\models\parametros\ParametrosDelegaciones;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InicEspumosoCabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


echo Dialog::widget([
    'libName' => 'krajeeDialogCust',
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
        ]
    ]);

$titulo = 'Solicitudes';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitud-index" >
    <br>
        <div class="well" align="center">
            <div class="panel panel-primary">
                <h4>Buscar <?= $titulo ?></h4>
            </div>    
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
        </div>
    <span>
        <div class="form-group" align="right">
            <?= Html::Button('<span class="glyphicon glyphicon-ok"></span> Presentar', ['id'=>'btAutorizacion','class' => 'btn btn-success']) ?>
        </div>
    </span>  

    <?php
    //opcion de actualizar
     $opcion_update =  function ($url,$model) {
        if($model->id_estado >=2 ){
            return "   ".Html::a(
                '   <span class="glyphicon glyphicon-eye-open"></span>',
                $url, 
                [
                    'title' => 'Ver'
                ]
            );
        } 
        //determina si se ve el boton de editar o el de ver
        if($model->id_estado ==1 ) {
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
            ['class' => 'kartik\grid\SerialColumn'],
            //'id',
            ['attribute'=>'id_usuario_solicitante','label'=>'Usuario Solicitante',
              'value'=>function($model){
                  if($model->usuarioSolicitante){
                    return $model->usuarioSolicitante->strAgente;
                  }else{
                    return "-"; 
                  }
               
               
                },
             ],
             [
                'attribute'=>'str_departamento',
                'label'=>'Departamento',
                
            ],
            [
                'attribute'=>'str_seccion',
                'label'=>'Sección',
                
            ],
            
            
            [
                'attribute'=>'fecha_solicitud',
                'label'=>'Fecha Solicitud',
                'format' => ['date', 'php:d/m/Y'],
            ],

            [
            'attribute'=>'tipo_solicitud' ,
                'label' => 'Tipo Solicitud',
                'value'=>function($model){
                    if($model->tipo_solicitud == 1){ 
                        return "Solicitud de Bien";
                        }else if($model->tipo_solicitud == 2){
                            return "Solicitud de Reparacion";
                            }else if ($model->tipo_solicitud == 3){
                                return "Solicitud de Baja";
                                    }
                                }
                            ],

                            [
                                'attribute'=>'id_estado_interno',
                                'label'=>'Tipo de Baja',
                                'value'=>function($model){
                                        if ($model->estadoInterno) {
                                            return $model->estadoInterno->denominacion;
                                        }else {
                                            return " - ";
                                        }
                                    }
                                    ], 
                            ['class' => '\kartik\grid\CheckboxColumn',
                            'header' => 'Presentar',
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                if ($model->id_estado == 1){
                                        return ['disabled' => false];
                                    } else{
                                        return ['disabled' => true];

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
                           
        ],   
                 
    ];

    ?>
    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridSolicitudPresenta',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
               'panel' => [
                   'type' => GridView::TYPE_INFO,
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
               'export' => [
                   'label' => 'Pagina',
                   'fontAwesome' => true,
               ],    
               'containerOptions'=>['style'=>'overflow: auto'],
               'headerRowOptions'=>['class'=>'kartik-sheet-style'],        
               'pjax'=>false,
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
$url = \yii\helpers\Url::to(['solicitud-cab/autorizacion-masiva']) ;
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
    $(function () {
            $('[data-toggle="tooltip"]').tooltip();
    });
    
    $('#btnConsultar').click(function(){
     
            
    });
    //
//metodo para presentar la solicitud, cambia el estado de borrador a pendiente
    $('#btAutorizacion').click(function(){
krajeeDialog.confirm("¿Quiere presentar esta Solicitud?", function (result) {
    if (result) { // ok button was pressed
        var keys = $('#gridSolicitudPresenta').yiiGridView('getSelectedRows');
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
                        $("#gridSolicitudPresenta").yiiGridView("applyFilter");
                    }
                }
           });
           window.location.reload();
    } else { // confirmation was cancelled
        krajeeDialog.alert("Se cancelo la presentación");
        
    }
});
});
JS;

$this->registerJs($script);
?>
