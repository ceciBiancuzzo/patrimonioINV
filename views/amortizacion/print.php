<?php

use \common\models\helpers;
use yii\helpers\Url;


use common\models\User;
use\patrimonio\models\Amortizacion;



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
                <h3 class="panel-title text-center">CIERRE DE EJERCICIO <?= $model->anio ?></h3> 
                <h3 class="panel-title text-center">AMORTIZACIÓNES</h3> 
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
		                            <TD><div class="col-xs-5"><strong>PARTIDA PRESUPUESTARIA </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>SALDO FINAL AL <?= $model->anio ?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>AMORTIZACION ACUMULADAS <?= $model->anio-1 ?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>AMORTIZACIONES DEL EJERCICIO</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>A.R.E.A</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>AJUSTE POR BAJAS EJERC</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>AMORTIZACIONES ACUMULADAS AL <?= $model->anio ?></strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong>VALOR RESIDUAL</strong></div></TD> 
	                            </TR>
                                <TR>
		                            <TD><div class="col-xs-5"><strong>4.3.1 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_431_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_431_amortizacion_acum_anterior ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_431?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_431_acumulada?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_431_valor_residual?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.2 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_432_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_432_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_432 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_432_acumulada ?></div></TD>  
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_432_valor_residual?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.3 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_433_precio_origen  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_433_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_433 ?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD>  
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_433_acumulada ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_433_valor_residual?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.4 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_434_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_434_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_434 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_434_acumulada ?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_434_valor_residual?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.5 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_435_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_435_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_435 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_435_acumulada ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_435_valor_residual ?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.6 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_436_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_436_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_436 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_436_acumulada ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_436_valor_residual?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.7 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_437_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_437_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_437 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_437_acumulada ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_437_valor_residual ?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.8 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_438_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_438_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_438 ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_438_acumulada ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_438_valor_residual ?></div></TD> 
	                            </TR><TR>
		                            <TD><div class="col-xs-5"><strong>4.3.9 </strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_439_precio_origen ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_439_amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_439 ?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_439_acumulada ?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->r_439_valor_residual ?></div></TD> 
                                    </TR>
                                    <TR>
		                            <TD><div class="col-xs-5"><strong>TOTALES</strong></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->precio_origen_total ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->amortizacion_acum_anterior  ?></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->amortizacion_anual?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><!-- ?= $model->id ?> --></div></TD> 
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->amortizacion_anual_acumulada ?></div></TD>
                                    <TD><div class="col-xs-5"><strong> </strong><?= $model->valor_residual?></div></TD> 
                                    </TR>
                                
                            </TABLE>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>
</HTML>