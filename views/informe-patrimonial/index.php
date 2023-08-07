<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use patrimonio\parametros\PatrimonioPartida;
use patrimonio\parametros\PatrimonioRubro;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\models\BienUso;
use patrimonio\models\Personal;
use gestion_personal\models\PersonalOrganigrama;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InicEspumosoCabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$perfil = '';
$busco_perfiles = Yii::$app->session->get('perfiles');
foreach ($busco_perfiles[17] as $roles){             //17 es el numero de la aplicacion de Patrimonio
    $perfil = $perfil . '-' . $roles;
} 
Modal::begin([
    'header' => '<h2>Consulta de informes</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],

]);
echo "<div id='modalContent'></div>";
Modal::end();

Modal::begin([
    'header' => '<h2>Carga de Archivos</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modalFile',
    'size' => 'modal-md',
    /*'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],*/
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentFile'></div>";
Modal::end();

echo Dialog::widget([
    'libName' => 'krajeeDialogCust', // a custom lib name
    'overrideYiiConfirm' => false,
    'options' => [
        'title' => 'My Dialog',
    ]
    ]);
$titulo = 'Informe patrimonial';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inic-espumoso-cab-index" >
    <br>

    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4><?= $titulo ?></h4>
        </div>    
        <?php    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 ){?>

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>
    <?php } ?>
    <?php
            
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute'=>'id',
             'label'=>'Area',
             'value'=>function($model){
                return $model->denominacion?$model->denominacion:" - ";
                },
            ],    
            ['attribute'=>'id_estado_formulario','label'=>'Estado presentación','value'=>function($model){
                return $model->estado?$model->estado->descripcion:" - ";
           }
            ], 
            ['attribute'=>'fecha_presentacion','label'=>'Fecha de presentación','value'=>function($model){
                return $model->fecha_presentacion?substr($model->fecha_presentacion,0,10):" - ";
           }
            ], 
         
       
        ['class' => 'kartik\grid\ActionColumn',
        'template' => ' {update}{print}',
        'buttons' => [
            'update' => function ($url,$model) {
                //print_r($searchModel);die();
                return "   ".Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    ['update', 'id'=>$model['id']] ,
                    [
                        'title' => 'Informe',
                        'data-pjax' => '0',

                        //'target'=>'_blank'
                        
                    ]
                );
            
        },
            'print' => function ($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-print"></span>',
                    ['print', 'area' => $model['id']],

                    [
                        'title' => 'imprimir bienes',
                        'data-pjax' => '0',
                        'target' => '_blank',
                    ]
                );
            },
           
            // 'index-detalle' => function ($urlUpdate,$searchModel) {
            //     return "   ".Html::a(
            //         '<span class="glyphicon glyphicon-pencil"></span>',
            //         $urlUpdate, 
            //         [
            //             'title' => 'Editar',
            //             'target'=>'_blank'
            //         ]
            //     );
            // },                            
        ], 
                       
    ],            
    ];
    ?>
    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridMovimientosInternos',
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'pager' => [
                'firstPageLabel' => 'Primera',
                'lastPageLabel' => 'Ultima',
            ],
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
                // if ($model->fecha_presentacion == null){
                //     return ['style' => 'visibility:collapse;'];
                // } else {
                //     return ['style' => 'visibility:visible;'];
                // }
                // if ($model->idestado == 0){
                //     return ['style' => 'visibility:collapse;'];
                // } else {
                //     return ['style' => 'visibility:visible;'];
                // }                
            }, 
           ]); 

        ?>
    </div>  
      
</div>
<?php 
//$urlUpdate = \yii\helpers\Url::to(['bien-uso/index-detalle']) ;
$url = Yii::$app->request->baseUrl. '/index.php?r=espumante-movimientos-internos-cab/presentacion-masiva';
$token = Yii::$app->request->getCsrfToken();
$script = <<< JS
    
    $(function(){
        $('#btImportacion').click(function(){
            $('#modalFile').modal('show')
                .find('#modalContentFile')
                .load($(this).attr('value'));
        });
        
        $('#btPresentacionMasiva').click(function(){
           var keys = $('#gridMovimientosInternos').yiiGridView('getSelectedRows');
           $.ajax({
                url: '$url',
                type: 'post',
                data: {
                          ids: keys, 
                          _csrf : '$token'
                      },
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.status == "SUCCESS")
                        $("#gridMovimientosInternos").yiiGridView("applyFilter");
                    else
                        krajeeDialog.alert(obj.message)
                }
           });
        }); 
      
        
    });
JS;

    $this->registerJs($script);
?>