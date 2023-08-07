<?php

use \common\models\helpers;
use yii\helpers\Url;

use patrimonio\models\ParametrosInscriptos;
use patrimonio\parametros\PatrimonioArea;
use gestion_personal\models\PersonalAgente;
use common\models\User;
use patrimonio\parametros\PatrimonioCondicionBien;
use\patrimonio\models\ActaTransferenciaCab;
use\patrimonio\models\ActaTransferenciaDet;


 
// $areaT=PatrimonioArea::findOne($model->id_seccion);
// $areaR=PatrimonioArea::findOne($model->id_seccion2);
// $usuarioT = PersonalAgente::findOne($model->id_usuario_transferencia);
// $usuarioR = PersonalAgente::findOne($model->id_usuario_recepcion);


?>

<HTML>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">	  
                    <img src="../web/imagenes/inv_logo.png" alt="inv">
                </div>		
                <div class="col-sm-5">
                    <h3 class="panel-title text-center"> MOVIMIENTO DE BIENES PATRIMONIALES</h3>
                    <!-- <strong> DETALLE TRANSFERENCIAS </strong> -->
                </div>
              		
            </div>				
        </div>

        <div class="row">
        <div class="col-sm-12">	
                <div class="panel panel-default">
                <div class="panel-heading">
                <div class="col-sm-12">	 
                    <p class="text-center">
                    <div class="panel-body">
                        <div class="row">    
                        <h3 class="panel-title text-center"> ACTA DE TRANSFERENCIA INTERNA</h3>
                            <div class="col-xs-10"><strong>1.- NUMERO ACTA: </strong><?= $model->nro_acta_transferencia ?></div>
                             <div class="col-xs-10"><strong>2.- DEPENDENCIA QUE TRANSFIERE: </strong><?= $model->areaTransferencia ? $model->areaTransferencia->denominacion:'-'?></div>
                             <div class="col-xs-10"><strong>3.- DEPENDENCIA QUE RECEPCIONA: </strong><?= $model->areaRecepciona ?  $model->areaRecepciona->denominacion:'-' ?></div>
                             <div class="col-xs-10"><strong>4.- FECHA TRANSFERENCIA: </strong><?= $model->fecha_transferencia ?></div>
                             <!-- <div class="col-xs-10"><strong>5.- NÚMERO TRANSFERENCIA: </strong>?= $model->id ?></div> -->
                             <div class="col-xs-10"><strong>6.- OBSERVACIONES: </strong><?= $model->observaciones ?></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Bienes</h3>
                </div>
                <div class="panel-body">		
                    <div class="row">
                        <div class="col-sm-12">
                            <?php        
                            if(!empty($model->detalles)){

                            ?> 
                          <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NÚMERO DE INVENTARIO</th>
                                        <th>MARCA</th>
                                        <th>MODELO</th>
                                        <th>NÚMERO DE SERIE</th>
                                        <th>TIPO DE BIEN</th>        
                                        <th>ESTADO</th>             
                                        <th>TIPO DE IDENTIFICACIÓN</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                                                    
                                    foreach ($model->detalles as $detalle){
                                  
                                    ?>
                                        <tr width="100%">
                                            <td> <h5><?= $detalle->bienUso ? $detalle->bienUso->nro_inventario: '-' ?></h5></td> 
                                            <td><h5><?= $detalle->bienUso->id_marca ? $detalle->bienUso->marcas->denominacion: '-' ?></h5></td> 
                                            <td> <h5><?= $detalle->bienUso ? $detalle->bienUso->modelo: '-' ?></h5></td> 
                                            <td> <h5><?= $detalle->bienUso ? $detalle->bienUso->nro_serie: '-' ?></h5></td> 
                                            <td> <h5><?= $detalle->bienUso ? $detalle->bienUso->tipo_bien: '-' ?></h5></td> 
                                            <td><h5><?= $detalle->condicionBien ? $detalle->condicionBien->descripcion:'-' ?></h5></td> 
                                            <!-- //$model->id_dependencia2)? $model->areaTransferencia->denominacion:'-' -->
                                            <td><h5><?=  $detalle->bienUso->tipo_identificacion ? $detalle->bienUso->tipo_identificacion:'-' ?></h5></td>                                      
                                            </tr> 
                                    <?php 
                                     
                                                                          
                                    }
                                    ?>
                                </tbody>
                          </table>
                            <?php
                          }else{
                            ?> 
                            <p>... SIN DETALLE ...</p>
                         <?php
                             }
                             ?>                         
                        </div>			
                    </div>
                </div>
            </div>
        </div>
        

    </div> 
   
    <h9>
            Usuario que transfirio
        </h9>
        <div class="col-xs-12"><?=  $model->usuarioTransferencia?$model->usuarioTransferencia->strAgente: '-' ?></div> <br>
   
        <h9>
            Usuario receptor
        </h9>
        <div class="col-xs-12"><?=  $model->usuarioRecepciona?$model->usuarioRecepciona->strAgente: '-' ?></div> <br>
     </body>
</HTML>
