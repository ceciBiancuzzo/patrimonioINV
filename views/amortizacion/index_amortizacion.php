
<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use kartik\export\ExportMenu;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\models\ActaRecepcionCabecera;
use gestion_personal\models\PersonalAgente;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\parametros\PatrimonioArea;
use patrimonio\parametros\PatrimonioRubro;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\dialog\Dialog;
use kartik\tabs\TabsX;
use patrimonio\models\search\AmortizacionSearch;










?>
 
     <div class="_form" align='center'>
     <div class="panel panel-primary" style="width:100%;margin-left:0px;margin-right:0px">
    <div class="panel-heading">
        <h3 class="panel-title" align='center'><i class="glyphicon glyphicon-pencil"></i> DETALLE AMORTIZACION ANUAL  </h3>
    </div>
    <div class="panel-body">
        <div class="row">
        </div>
        <?php
 

 
    $searchModel = new AmortizacionSearch();

    
    if($model->getAttribute('id') != null){
        
        
        ?>
     
        <?php


            $items = [

                        [
                            'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 431',
                            'content'=>$this->render('index_r_431',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,431),'model'=>$model]),
                            
                        ],
                         [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 432',
                           'content'=>$this->render('index_r_432',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,432),'model'=>$model]),
                           
                       ],
                       [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 433',
                           'content'=>$this->render('index_r_433',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,433),'model'=>$model]),
                           
                        ],
                        [
                            'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 434',
                            'content'=>$this->render('index_r_434',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,434),'model'=>$model]),
                            
                        ],
                                            [
                            'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 435',
                           'content'=>$this->render('index_r_435',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,435),'model'=>$model]),
                            
                        ],
                        [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"> </i> 436',
                           'content'=>$this->render('index_r_436',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,436),'model'=>$model]),
                           

                        ],

                       [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 437',
                           'content'=>$this->render('index_r_437',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,437),'model'=>$model]),
                        ],

                       [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 438',
                           'content'=>$this->render('index_r_438',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,438),'model'=>$model]),
                           
                       ],
                       [
                           'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 439',
                         'content'=>$this->render('index_r_439',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,439),'model'=>$model]),
                           
                       ],  
                       [
                        'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 481',
                      'content'=>$this->render('index_r_439',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,481),'model'=>$model]),
                        
                    ],  
                    [
                        'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 411',
                      'content'=>$this->render('index_r_439',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,411),'model'=>$model]),
                        
                    ],  
                    [
                        'label'=>'<i class="glyphicon glyphicon-folder-open"></i> 412',
                      'content'=>$this->render('index_r_439',['dataProvider'=>$searchModel->searchBienAmortizado($model->id_bien_uso,412),'model'=>$model]),
                        
                    ],  


            ];
     
            echo TabsX::widget([
                'items'=>$items,
                'position'=>TabsX::POS_ABOVE,
                'encodeLabels'=>false
            ]);
        }

            ?>
                    

</div>
</div>
