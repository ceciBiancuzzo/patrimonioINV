<?php

use \common\models\helpers;
use yii\helpers\Url;

use patrimonio\models\ParametrosInscriptos;
use patrimonio\parametros\PatrimonioArea;
use gestion_personal\models\PersonalAgente;
use common\models\User;
use patrimonio\parametros\PatrimonioCondicionBien;
//use aprobacion_ddjj\models\CosechaParteSemanalCab;
use parametros\models\ParametrosDelegaciones;
use patrimonio\models\PatrimonioEstadoInterno;
use patrimonio\parametros\ParametrosTipoSolicitud;

//$areaT=PatrimonioArea::findOne($model->id_area_solicitante);
$usuarioS = PersonalAgente::findOne($model->id_usuario_solicitante);
$estadosFormularios = patrimonio\parametros\PatrimonioEstadosFormularios::find()->all();
//$delegaciones = common\models\parametros\ParametrosDelegaciones::find()->all();
$bienes= patrimonio\models\BienUso::find()->all();
$areas= patrimonio\parametros\PatrimonioArea::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$tipoSolicitud = "";

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
                <h3 class="panel-title text-center"> SOLICITUD</h3>
                </div>
                <div class="col-sm-1"></div>			
            </div>				
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">
                        <div class="panel-body">
                            <TABLE BORDER>
	                            <TR>
		                            <TD><div class="col-xs-5"><strong>1.- NUMERO DE ID DE LA SOLICITUD: </strong><?= $model->id ?></div></TD> 
	                            </TR>
                                <?php        
                                if($model->tipo_solicitud == 1){ 
                                    $tipoSolicitud=" SOLICITUD DE BIEN";
                                    }else if($model->tipo_solicitud == 2){
                                        $tipoSolicitud= " SOLICITUD DE REPARACIÓN";
                                        }else if ($model->tipo_solicitud == 3){
                                            $tipoSolicitud= " SOLICITUD DE BAJA";
                                                }

                                if($model->id_estado == 1){ 
                                    $estado = "BORRADOR";
                                    }else if($model->id_estado == 2){
                                        $estado = "PENDIENTE";
                                        }else if ($model->id_estado == 3){
                                            $estado = "APROBADO";
                                                }else if ($model->id_estado == 4){
                                                    $estado = "RECHAZADO";
                                                        }else if ($model->id_estado == 5){
                                                            $estado = "RECIBIDO";
                                                                }
                                            
                                ?>
                                <TR>
		                            <TD><div class="col-xs-5"><strong>2.- TIPO:</strong><?=$tipoSolicitud?></div></TD> 
	                            </TR>
                                <TR>
		                            <TD><div class="col-xs-5"><strong>3.- ESTADO SOLICITUD: </strong><?= $estado ?></div></TD> 
	                            </TR> 
                                <TR>
		                            <TD><div class="col-xs-5"><strong>4.- USUARIO QUE SOLICITA: </strong><?= $usuarioS->apellido.' '.$usuarioS->nombre ?></div></TD> 
	                            </TR>
                                <TR>
		                            <TD><div class="col-xs-5"><strong>5.- AREA SOLICITANTE: </strong><?=strtoupper( $model->str_seccion)?></div></TD> 
	                            </TR>  
                                <TR>
		                            <TD><div class="col-xs-5"><strong>6.- DEPARTAMENTO SOLICITANTE: </strong><?=strtoupper( $model->str_departamento)?></div></TD> 
	                            </TR>  
                                <TR>
		                            <TD><div class="col-xs-5"><strong>7.- FECHA DE SOLICITUD: </strong><?= $model->fecha_solicitud ?></TD> 
	                            </TR>
                                </TABLE>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

     <div class="row">
        <div class="col-sm-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Detalles</h3>
                </div>
                    <div class="panel-body">
                    <div class="row">		
                        <div class="col-md-5">
                            <?php        
                                if(!empty($model->detalles)){
                            ?> 
                                <table class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>BIEN USO</th>
                                        <th>CANTIDAD</th>
                                        <th>OBSERVACIONES</th>                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                  
                                    foreach ($model->detalles as $detalle){
                                    ?>
                                        <tr>
                                            <td><h5><?= $detalle->id ?></h5></td> 
                                            <td><h5><?= $detalle->biendeUso->tipo_bien?></h5></td>
                                            <td><h5><?= $detalle->cantidad_solicitada?></h5></td> 
                                            <td><h5><?= $detalle->observaciones ?></h5>                                  
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
    <table>
        <tr>
            <td>
                <h9>
                    La declarante afirma que los datos consignados en el anverso y reverso del presente formulario son correctos y esta declaración 
                    se ha confeccionado sin omitir ni falsear dato alguno siendo fiel expresión de la verdad por lo que reviste carácter de Declaración Jurada 
                </h9>    
            </td>    
        </tr>
        <tr>
            <td>
                <h9>
    
                </h9>               
            </td>
        </tr>
        <tr>
            <td>
                <h9>
                    Nro. de Control: 
                </h9>               
            </td>
        </tr>
        <tr>
            <td>
                <h9>
                    Responsables: 
                    </h9>               
            </td>
        </tr>
    </table>
</body>
</HTML>