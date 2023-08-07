<?php

use yii\helpers\Url;
use common\models\helpers;
use common\models\User;
use common\models\parametros\ParametrosDelegaciones;
use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\models\ActaRecepcionDetalle;
use patrimonio\models\BienUso;
use patrimonio\models\ParametrosInscriptos;
use gestion_personal\models\PersonalAgente;
use patrimonio\parametros\PatrimonioArea;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioFormaAdquisicion;

$BiendeUso = patrimonio\models\BienUso::find()->where(['id_acta_recepcion_definitiva'=> $model->nro_acta])->andWhere(['!=','id_estado_interno',18])->andWhere(['fecha_baja' => null])->all();
$detalles = patrimonio\models\ActaRecepcionDetalle::find()->where(['id_cab'=>$model->id])->andWhere(['fecha_baja' => null])->all();
$formaAdquisicion = PatrimonioFormaAdquisicion::find()->all();
$comision = patrimonio\models\PatrimonioComision::find()->all();
$personas= gestion_personal\models\PersonalAgente:: find()->all();

// echo "<pre>";
// print_r($BiendeUso);
// echo "</pre>";
// die();
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
                <div class="col-sm-20">	  
                    <img src="../web/imagenes/inv_logo.png" alt="inv">
                </div>		
                <div class="col-sm-5">
                    <h3 class="panel-title text-center"> DETALLE DE ACTA DE RECEPCION</h3>
                </div>	
            </div>				
        </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="text-center">
                            <div class="panel-body">
                                <div class="row">
                                    <div ><strong>1- AREA ADQUIRENTE </strong><?= $model->seccion?$model->seccion->strDependencia:'-'?></div>
                                    <div><strong>2- FECHA DE ACTA: </strong><?= $model->fecha_acta ?></div>
                                    <div><strong>3- NUMERO DE ACTA: </strong><?= $model->nro_acta ?></div>
                                    <div ><strong>4- ORDEN DE COMPRA: </strong><?= $model->orden_compra ?></div>   
                                    <div ><strong>5- NUMERO DE EXPEDIENTE: </strong><?= $model-> nro_expediente ?></div>
                                    <div ><strong>6- FORMA ADQUISICION: </strong><?= $model->formaAdquisicion?$model->formaAdquisicion->denominacion: '-' ?></div>
                                    <div ><strong>7- COMISION DE RECEPCION: </strong><?=  $model->comision?$model->comision->denominacion: '-' ?></div>
                                    <div ><strong>8- NUMERO DE GDE: </strong><?= $model-> nro_gde ?></div>
                                    <br/>                    
                                    <div><strong>INFORME TECNICO:</strong><br><?= $model->texto_acta ?> </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"> Detalles</h3>
                    </div>
                    <div class="panel-body">		
                        <div class="row">
                            <div class="col-xs-12">
                                <?php        
                                    if(!empty($detalles)){
                                ?> 
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>RENGLON</th>
                                                <th>BIEN</th>
                                                <th>GARANTIA</th>
                                                <th>CANTIDAD</th>
                                                <th>PROVEEDOR</th>   
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <?php
                                                foreach ($detalles as $detalle){                                        
                                            ?>
                                            <tr width="100%" >
                                                <td><h6><?= $detalle->renglon ?></h6></td> 
                                                <td><h6><?= $detalle->bienUso->tipo_bien?></h6></td>
                                                <td><h6><?= $detalle->garantia?></h6></td>
                                                <td><h6><?= $detalle->cantidad ?></h6></td>
                                                <td><h6><?= $detalle->proveedor?$detalle->proveedor->denominacion:'-'?></h6></td>
                                            </tr>
                                            <?php 
                                                // reuno en un array los id de los detalles que tienen terceros, para solo mostrar esos terceros                                  
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"> Numeros de Serie</h3>
                    </div>
                    <div class="panel-body">		
                        <div class="row">
                            <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>BIEN</th>
                                                <th>MARCA</th>
                                                <th>NUMERO DE SERIE</th>  
                                            </tr>
                                        </thead>
                                        <tbody >
                                            
                                            <?php
                                                foreach ($BiendeUso as $bien){                                        
                                            ?>
                                            <tr width="100%" >
                                                <td><h6><?= $bien->tipo_bien ?></h6></td> 
                                                <td><h6><?= $bien->marcas?$bien->marcas->denominacion:'-' ?></h6></td> 
                                                <td><h6><?= $bien->nro_serie ?></h6></td> 
        
                                            </tr>
                                            <?php 
                                                // reuno en un array los id de los detalles que tienen terceros, para solo mostrar esos terceros                                  
                                            }
                                            ?>
                                        </tbody>
                                </table>                   
                            </div>			
                        </div>
                    </div>
                </div>
        <h9>
            La declarante afirma que los datos consignados en el anverso y reverso del presente formulario son correctos y esta declaración 
            se ha confeccionado sin omitir ni falsear dato alguno siendo fiel expresión de la verdad por lo que reviste carácter de Declaración Jurada 
            Nro. de Control: 
            Responsables: 
        </h9>
        <h4  class="text-center"><strong> FIRMA COMISIÓN DE RECEPCIÓN <strong></h4>  <br>                     
    </body> 
<<<<<<< HEAD
     <div class="col-xs-12">-<?=  $model->comision->persona_1?$model->comision->persona_1->strAgente: '-' ?></div> <br>
     <div class="col-xs-12">-<?=  $model->comision->persona_2?$model->comision->persona_2->strAgente: '-' ?></div> <br>
     <div class="col-xs-12">-<?=  $model->comision->persona_3?$model->comision->persona_3->strAgente: '-' ?></div> <br>
     <div class="col-xs-12">-<?=  $model->comision->persona_4?$model->comision->persona_4->strAgente: '-' ?></div> <br>
     <div class="col-xs-12">-<?=  $model->comision->persona_5?$model->comision->persona_5->strAgente: '-' ?></div> <br>
     <div class="col-xs-12">-<?=  $model->comision->persona_6?$model->comision->persona_6->strAgente: '-' ?></div> <br>
</HTML>

=======
    <?php
    if($model->comision != null){
        if($model->comision->persona_1 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_1?$model->comision->persona_1->strAgente: '-' ?></div> <br>
    <?php }} ?>
    <?php
    if($model->comision != null){
        if($model->comision->persona_2 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_2?$model->comision->persona_2->strAgente: '-' ?></div> <br>
    <?php }} ?>
    <?php
    if($model->comision != null){
        if($model->comision->persona_3 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_3?$model->comision->persona_3->strAgente: '-' ?></div> <br>
    <?php } }?>
    <?php
    if($model->comision != null){
        if($model->comision->persona_4 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_4?$model->comision->persona_4->strAgente: '-' ?></div> <br>
    <?php } }?>
    <?php
    if($model->comision != null){
        if($model->comision->persona_5 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_5?$model->comision->persona_5->strAgente: '-' ?></div> <br>
    <?php } } ?>
    <?php
    if($model->comision != null){
        if($model->comision->persona_6 != null){?>
     <div class="col-xs-12">-<?=  $model->comision->persona_6?$model->comision->persona_6->strAgente: '-' ?></div> <br>
    <?php }} ?>
</HTML>
>>>>>>> aprobacion_bodega-gerFinal
