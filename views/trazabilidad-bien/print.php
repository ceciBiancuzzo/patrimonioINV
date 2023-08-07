<?php

use \common\models\helpers;
use yii\helpers\Url;
use gestion_personal\models\PersonalAgente;



$count=0;
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
                    <img src="../web/imagenes/inv_logo.png" alt="inv" width="192" height="54" >
                </div>		
                <div class="col-sm-5">
                <h3 class="panel-title text-center">TRAZABILIDAD</h3> 
                
                </div>
                <div class="col-sm-1"></div>			
            </div>				
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">
                        <div class="panel-body">



                            <TABLE BORDER=1 CELLPADDING=10 CELLSPACING=0>
	                            <TR>
		                            <TD><div class="col-xs-5"><strong>ID</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>BIEN DE USO</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>CONDICION</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>ESTADO INTERNO</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>ESTADO FORUMULARIO</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>USUARIO ACTUAL</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>ID RECEPCION</strong></div></TD>
                                    <TD><div class="col-xs-5"><strong>ID TRASFERENCIA</strong></div></TD>
                                    <!-- <TD><div class="col-xs-5"><strong>ID SOLICITUD</strong></div></TD> -->
                                    <TD><div class="col-xs-5"><strong>FECHA</strong></div></TD>
                                    <TD><div class="col-xs-5"><strong>TIPO MOVIMIENTO</strong></div></TD>
	                            </TR>
                               
                                <?php for ($i=0; $i < count($model) ; $i++) { 
                                    if($model[$i]->id_estado_formulario == 1){ 
                                        $formulario= "Borrador";
                                        }else if($model[$i]->id_estado_formulario == 2){
                                            $formulario= "Pendiente";
                                                }else if ($model[$i]->id_estado_formulario == 3){
                                                    $formulario= "Aprobado";
                                                        }else if ($model[$i]->id_estado_formulario == 4){
                                                            $formulario= "Rechazado";
                                                                }else if ($model[$i]->id_estado_formulario == 5){
                                                                    $formulario= "Recibido";
                                                                        }else if ($model[$i]->id_estado_formulario == null){
                                                                            $formulario= " - ";
                                                                                }
                                    ?>
                                <TR>
		                            <TD><div class="col-xs-5"><strong><?=$model[$i]->id ?></strong></div></TD>
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->bienUso?$model[$i]->bienUso->strBien:"-";?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->condicion?$model[$i]->condicion->descripcion:"-"; ?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->estadoInterno?$model[$i]->estadoInterno->denominacion:"-"?></strong></div></TD>  
                                    <TD><div class="col-xs-5"><strong><?= $formulario?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->id_usuario_actual?$model[$i]->usuarioAsignado->strAgente:"-"?></strong></div></TD>
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->nroActaRecepcion?$model[$i]->nroActaRecepcion->nro_acta:"-"?></strong></div></TD>
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->id_transferencia?$model[$i]->id_transferencia:"-"?></strong></div></TD>
                                    <!-- <TD><div class="col-xs-5"><strong>?=$model[$i]->id_solicitud?$model[$i]->id_solicitud:"-"?></strong></div></TD> -->
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->fecha_carga?$model[$i]->fecha_carga:"-"?></strong></div></TD>
                                    <TD><div class="col-xs-5"><strong><?=$model[$i]->tipo_movimiento?$model[$i]->tipo_movimiento:"-"?></strong></div></TD>
	                            </TR>
                                <?php } ?>
                            </TABLE>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
            


</body>
</HTML>