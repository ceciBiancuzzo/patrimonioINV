<?php

use \common\models\helpers;
use yii\helpers\Url;

use patrimonio\models\ParametrosInscriptos;
use patrimonio\parametros\PatrimonioArea;
use gestion_personal\models\PersonalAgente;
use common\models\User;
use patrimonio\parametros\PatrimonioCondicionBien;
use patrimonio\parametros\PatrimonioEstadoInterno;
use patrimonio\parametros\PatrimonioRubro;
use patrimonio\parametros\PatrimonioPartida;

//use aprobacion_ddjj\models\CosechaParteSemanalCab;
use\patrimonio\models\BienUsoContables;
use\patrimonio\models\BienUsoGarantia;

//  $areaT=PatrimonioArea::findOne($model->id_area_transferencia);
//  $areaR=PatrimonioArea::findOne($model->id_area_recepcion);
 
//   $usuarioT = PersonalAgente::findOne($model->id_usuario_transferencia);
//   $usuarioR = PersonalAgente::findOne($model->id_usuario_recepcion);
   $condicionBien =PatrimonioCondicionBien::findOne($model->id_condicion);
   $estadoInterno = PatrimonioEstadoInterno::findOne($model->id_estado_interno);
   $rubro = PatrimonioRubro::findOne($model->id_rubro);
   //$partida = PatrimonioPartida::findOne($model->id_partida);
//   $condicionBien = ActaTransferenciaDet::findOne($model->id_condicion)
//   ->innerJoin(['condicion'])
 // ->where(['tipo_alta' => 'AL', 'numero' => $model->numero])
 // ->all();
 $dependencias = patrimonio\parametros\PatrimonioDependencia::find()->all();
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
                <h3 class="panel-title text-center">DETALLE DEL BIEN DE USO</h3> 
                </div>
                <div class="col-sm-1"></div>			
            </div>				
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="text-center">
                        <div class="panel-body">
                            <TABLE BORDER=1 CELLPADDING=5 CELLSPACING=0>
                            
                                <TR>
                                     <td rowspan="5"> <div class="col-xs-5"><strong>DATOS DEL ESTADO DEL BIEN</strong></div></td>
                                </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Usuario actual:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->id_usuario_bien?$model->usuarioAsignado->strAgente:"-" ?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Ubicación del bien:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->dependencia?$model->dependencia->strDependencia:"-" ?></strong></div></TD> 
	                            </TR>
                               
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Estado interno:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->estadoInterno?$model->estadoInterno->denominacion:"-" ?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Condicion:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->condicion?$model->condicion->descripcion:"-" ?></strong></div></TD>  
	                            </TR>
 
                                <TR>
                                     <td rowspan="9"> <div class="col-xs-5"><strong>DATOS ESPECIFICOS BIEN</strong></div></td>
                                </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Rubro:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$rubro->denominacion?$rubro->strRubro:"-" ?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Tipo de bien:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->tipo_bien?$model->tipo_bien:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Descripcion del bien:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->descripcion_bien?$model->descripcion_bien:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Marca:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->id_marca?$model->marcas->denominacion:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Modelo:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->modelo?$model->modelo:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Número de inventario:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->nro_inventario?$model->nro_inventario:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Numero de serie:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->nro_serie?$model->nro_serie:"-"?></strong></div></TD>  
	                            </TR>
                                
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Tipo de identificación:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->tipo_identificacion?$model->tipo_identificacion:"-"?></strong></div></TD>  
	                            </TR>

                                <TR>
                                     <td rowspan="8"> <div class="col-xs-5"><strong>DATOS DE AMORTIZACION</strong></div></td>
                                </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Valor de origen:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->precio_origen?$model->precio_origen:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Año de alta:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->anio_alta?$model->anio_alta:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Vida útil:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->vida_util?$model->vida_util:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Vida útil trascurrida:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->vida_util_transcurrida?$model->vida_util_transcurrida:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Amortizacion anual:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->amortizacion_anual?$model->amortizacion_anual:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Amortizacion anual acumulada:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->amortizacion_anual_acumulada?$model->amortizacion_anual_acumulada:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Valor Residual:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->valor_residual?$model->valor_residual:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                     <td rowspan="3"> <div class="col-xs-5"><strong>DATOS ADMINISTRATIVOS</strong></div></td>
                                </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Acto administrativo:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->acto_admin?$model->acto_admin:"-"?></strong></div></TD>  
	                            </TR>
                                <TR>
                                    <TD><div class="col-xs-5"><strong>Cargo anterior a la baja:</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong><?=$model->obvs_admin?$model->obvs_admin:"-"?></strong></div></TD>  
	                            </TR>
                          
                                </TABLE>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>
</HTML>
                            
                          


     <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Detalles contables</h3>
                </div>
                <div class="panel-body">		
                    <div class="row">
                        <div class="col-md-12">
                        <?php        
                        if(!empty($model->detallesContables)){

                        ?> 
                          <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bien de uso</th>
                                        <th>Ejercicio</th>
                                        <th>Tipo de adquisición</th>
                                        <th>Motivo de adquisición</th>
                                        <th>Submotivo de adquisición</th>
                                        <th>Dominio</th>
                                        <th>Entidad cedente</th>
                                        <th>Observaciones</th>                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   //  $detallesContables= $model->detallesContables;
        
                                        
                                    ?>
                                        <tr width="100%">
                                            <td><?= $model->detallesContables->id ?></td> 
                                            <!-- <td>?= $detalle->bienUso->tipo_bien ?></td> -->
                                             <td><?= $model->detallesContables->id_bien_uso ?></td> 
                                             <td><?= $model->detallesContables->ejercicio ?></td> 
                                             <td><?= $model->detallesContables->tipo_adquisicion ?></td> 
                                             <td><?= $model->detallesContables->motivo ?></td> 
                                             <td><?= $model->detallesContables->dominio ?></td> 
                                             <td><?= $model->detallesContables->submotivo ?></td> 
                                             <td><?= $model->detallesContables->entidad_cedente ?></td> 
                                             <td><?= $model->detallesContables->observaciones ?></td> 
                                            </td>                                           
                                        </tr>
                                    <?php 
                                        // reuno en un array los id de los detalles que tienen terceros, para solo mostrar esos terceros
                                                                          
                                    
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
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Detalles de garantía</h3>
                </div>
                <div class="panel-body">		
                    <div class="row">
                        <div class="col-md-12">
                        <?php        
                        if(!empty($model->detallesGarantia)){

                        ?> 
                          <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bien de uso</th>
                                        <th>Ejercicio</th>
                                        <th>Tipo de adquisición</th>
                                        <th>Motivo de adquisición</th>
                                        <th>Submotivo de adquisición</th>
                                        <th>Dominio</th>
                                        <th>Entidad cedente</th>
                                        <th>Observaciones</th>                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $detallesGarantia= $model->detallesGarantia;
        
                                        
                                    ?>
                                        <tr width="100%">
                                            <td><?= $detallesGarantia->id ?></td> 
                                            <!-- <td>?= $detalle->bienUso->tipo_bien ?></td> -->
                                             <td><?= $detallesGarantia->id_bien_uso ?></td> 
                                             <td><?= $detallesGarantia->empresa ?></td> 
                                             <td><?= $detallesGarantia->periodo_garantia ?></td> 
                                             <td><?= $detallesGarantia->documento_respaldatorio ?></td> 
                                             <td><?= $detallesGarantia->fecha_inicio ?></td> 
                                             <td><?= $detallesGarantia->fecha_fin ?></td> 
                                             <td><?= $detallesGarantia->observaciones ?></td> 
                                            </td>                                           
                                        </tr>
                                    <?php 
                                        // reuno en un array los id de los detalles que tienen terceros, para solo mostrar esos terceros
                                                                          
                                    
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
     <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"> Detalles del seguro</h3>
                </div>
                <div class="panel-body">		
                    <div class="row">
                        <div class="col-md-12">
                        <?php        
                        if(!empty($model->detallesSeguro)){

                        ?> 
                          <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bien de uso</th>
                                        <th>Ejercicio</th>
                                        <th>Tipo de adquisición</th>
                                        <th>Motivo de adquisición</th>
                                        <th>Submotivo de adquisición</th>
                                        <th>Dominio</th>
                                        <th>Entidad cedente</th>
                                        <th>Observaciones</th>                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $detallesSeguro= $model->detallesSeguro;
        
                                        
                                    ?>
                                        <tr width="100%">
                                            <td><?= $detallesSeguro->id ?></td> 
                                            <!-- <td>?= $detalle->bienUso->tipo_bien ?></td> -->
                                             <td><?= $detallesSeguro->id_bien_uso ?></td> 
                                             <td><?= $detallesSeguro->empresa ?></td> 
                                             <td><?= $detallesSeguro->numero_poliza ?></td> 
                                             <td><?= $detallesSeguro->forma_pago ?></td> 
                                             <td><?= $detallesSeguro->prima ?></td> 
                                             <td><?= $detallesSeguro->importe ?></td> 
                                             <td><?= $detallesSeguro->condiciones ?></td> 
                                             <td><?= $detallesSeguro->fecha_inicio ?></td> 
                                             <td><?= $detallesSeguro->fecha_fin ?></td> 
                                            </td>                                           
                                        </tr>
                                    <?php 
                                        // reuno en un array los id de los detalles que tienen terceros, para solo mostrar esos terceros
                                                                          
                                    
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
    La declarante afirma que los datos consignados en el anverso y reverso del presente formulario son correctos y esta declaración 
    se ha confeccionado sin omitir ni falsear dato alguno siendo fiel expresión de la verdad por lo que reviste carácter de Declaración Jurada 
    Nro. de Control: 
    Responsables: 
   

</h9>



</body>
</HTML>