<?php

//use yii\helpers\Html;
//use yii\widgets\DetailView;

use kartik\grid\GridView;

use kartik\detail\DetailView;
use kartik\helpers\Html;
use kartik\widgets\DatePicker;
//use kartik\datecontrol\DateControl;   //no esta instalada aun

use kartik\tabs\TabsX;



/* @var $this yii\web\View */
/* @var $model frontend\models\InicEspumosoCab */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inic Espumoso Cabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = "algo ".$this->title;
?>
<div class="inic-espumoso-cab-view">

    <!-- <h1>? = Html::encode($this->title) ?></h1> -->
    
    <?php
            $modo = DetailView::MODE_EDIT;
            if (!$model->isNewRecord){
                $modo = DetailView::MODE_VIEW;
            }
            
            echo  Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Está seguro que quiere borrar este ítem?',
                            'method' => 'post',
                        ],
                    ]);

   
    $attributes = [
      /*  [
            'group'=>true,
            'label'=>'Detalle de INIC',
            'rowOptions'=>['class'=>'success']
        ],*/
        [
            'columns' => [
                [
                    'attribute'=>'id', 
                    'format'=>'raw',
                    'labelColOptions'=>['class'=>'kv-view-hidden'],
                    'valueColOptions'=>['class'=>'kv-view-hidden'],
                    'type'=>DetailView::INPUT_HIDDEN, 

                ],

            ],
        ],        
        [
            'columns' => [
                [
                    'attribute'=>'nroins', 
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:10%'],'labelColOptions'=>['style'=>'width:10%']
                ],
                [
                    'attribute'=>'rsocial', 
                    'valueColOptions'=>['style'=>'width:80%'],'labelColOptions'=>['style'=>'width:10%'] 

                ],
            ],
        ],
        [
            'columns' => [
                /*[
                    'attribute'=>'fecha_alta','format'=>['date', 'dd/MM/yyyy'],'type'=>DetailView::INPUT_WIDGET,
                    'widgetOptions' => [
                        'class'=>DateControl::classname(),
                        'type'=>DateControl::FORMAT_DATE,
                    ],'valueColOptions'=>['style'=>'width:12%'],'labelColOptions'=>['style'=>'width:10%']
                ],   */                   
                [
                    'attribute'=>'estadecla', 
                    'valueColOptions'=>['style'=>'width:30%'],'labelColOptions'=>['style'=>'width:10%']
                ],
            ],
        ],   
    ];
    
    $permite_editar = '{update}';
    ?>   
    <p></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'mode' => 'view',
        'buttons1'=>'',
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'fadeDelay'=>750,
        'deleteOptions'=>[ // your ajax delete parameters
            //'params' => ['id' => 1000, 'kvdelete'=>true],
            'url'=>\yii\helpers\Url::to(['delete','id'=>$model->id]),
            'params' => ['id' => $model->id, 'custom_param' => true],
        ],
        'container' => ['id'=>'kv-demo'],
       // 'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])], // your action to delete,
        
        
        'panel'=>[
            'heading'=>'INIC Id ' . $model->id,
            'type'=>DetailView::TYPE_SUCCESS,
        ],        
        
    ]) ?>
    
    <p></p>
    
    <?php
    
    $gridColumnsDet = [
            ['class' => 'kartik\grid\SerialColumn'],
            'id',
            'id_cabecera',
            'codpro',
            'codgru',      
            ['class' => 'kartik\grid\ActionColumn','template' => '{view}'],          
    ];    
    
    
        $items = [
            [
                'label'=>'<i class="glyphicon glyphicon-home"></i> Detalle 1',
                'content'=>GridView::widget([
                                'dataProvider' => $dataProviderDetalle,
                                'columns' => $gridColumnsDet,
                                   'panel' => [
                                       'type' => GridView::TYPE_INFO,
                                       'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-home"> </i> Registros cargados</h3> <br>' . Html::a('Nuevo Registro', ['create'], ['class' => 'btn btn-success']) ,
                                   ],  

                                   'toolbar' =>  [ 
                                       ['content'=>
                                           Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Resetear Grilla'])
                                       ], 

                                       '{export}',
                                       //$fullExportMenu,
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
                                   'pjax'=>true, // pjax is set to always true for this demo
                                   'persistResize'=>false,
                                   'responsive'=>true,
                                   'hover'=>true,  

                               ]),
                'active'=>true
            ],
            [
                'label'=>'<i class="glyphicon glyphicon-user"></i> Detalle 2',
                'content'=>"content2"
            ],
        ];

// Above
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'bordered'=>true,
    'encodeLabels'=>false
]);


    ?>

</div>
