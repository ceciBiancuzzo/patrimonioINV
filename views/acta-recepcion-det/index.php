<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\InicEspumosoCabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Modal::begin([
    'header' => '<h2>Movimientos Internos</h2>',
    //'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
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

$titulo = 'Acta de Recepción';
$this->title = $titulo;
$this->params['breadcrumbs'][] = $this->title;

//$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();

?>
<div class="inic-espumoso-cab-index" >
    <br>
    <div class="well" align="center">
        <div class="panel panel-primary">
            <h4>Consulta de <?= $titulo ?></h4>
        </div>    
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>    
    </div>
    
    <?php
            
    $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            'id',
            [
                'attribute'=>'id_delegacion',
                'label'=>'Delegacion',
                //'value'=>function($model){
                //return $model->$delegaciones?$model->$delegaciones->codigo_delegaciones:'';
                //},
            ],        
            [
                'attribute'=>'anoinv',
                'label'=>'Año',
                'format'=>[
                    'date',
                    'php:Y'
                ],
                'value'=>function($model){
                    //return $model->numero?$model->numero:'-';
                },
            ],
            [
                'attribute'=>'orden_compra',
                'label'=> 'Orden de Compra'
            ],
            [
                'attribute'=>'id_condicion',
                'label'=>'Condicion del Bien',
            ],
            [
                'attribute'=>'fecha_acta',
                'label'=>'Fecha de Acta'
            ],
             //['attribute'=>'fecha_presentacion',
             //'format'=>['date', 'php:d/m/Y H:i:s']   ],            
            [
                'attribute'=>'nro_acta',
                'label'=>'Numero de Acta',
            ],
            ['class' => 'kartik\grid\ActionColumn',
                'template' => ' {view}{print}',
                'buttons' => [
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
            ],          
    ];
    ?>
    <div  class="well">
        <?= GridView::widget([
            'id'=>'gridMovimientosInternos',
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