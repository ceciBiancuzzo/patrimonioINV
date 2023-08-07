<?php

use yii\helpers\Url;
use gestion_personal\models\PersonalAgente;
use common\models\helpers;
use common\models\User;
use patrimonio\models\InformePatrimonial;
use patrimonio\models\BienUso;
use patrimonio\models\PatrimonioRubro;
use patrimonio\parametros\PatrimonioMarca;


$marcas= patrimonio\parametros\PatrimonioMarca::find() ->orderBy(['id' => SORT_DESC])->all();
//  $partida = patrimonio\parametros\PatrimonioPartida::find()->all();
$rubro = patrimonio\parametros\PatrimonioRubro::find()->all();
$estados= patrimonio\parametros\PatrimonioEstadoInterno::find()->all();
$condiciones = patrimonio\parametros\PatrimonioCondicionBien::find()->all();
$usuario= gestion_personal\models\PersonalAgente::find()->all();
$dependencia= patrimonio\parametros\PatrimonioArea::find()->where(['id'=>$area])->one();
//$area = $dependencia->id;
?>
<HTML>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">	  
                    <img src="../web/imagenes/inv_logo.png" alt="inv">
                    <h3 class="panel-title text-center"> INFORME PATRIMONIAL DEPENDENCIA : <?=$dependencia->codigo_dependencia.' - '.strtoupper($dependencia->denominacion)?> </h3>
                </div>		
            </div>				
        </div>
    </head>
    <body>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-body">
                        <table BORDER=1 CELLPADDING=5 CELLSPACING=0>
                            <tr>
                                <th class="text-center" scope="col">Nº INVENTARIO</th>
                                <th class="text-center" scope="col">AÑO ALTA</th>
                                <th class="text-center" scope="col">BIEN DE USO</th>
                                <th class="text-center" scope="col">CONDICIÓN</th>
                                <th class="text-center" scope="col">IDENTIFICACIÓN</th>
                                <th class="text-center" scope="col">USUARIO ASIGNADO</th>

                            </tr>
                                <?php
                                    if(!empty($model)){
                                    foreach($model as $models){
                                ?>
                            <tr>
                                <td class="text-center"><h6><?= $models->nro_inventario?$models->nro_inventario:'-' ?></h6></td> 
                                <td class="text-center"><h6><?= $models->fecha_carga?substr($models->fecha_carga,0,4):'-' ?></h6></td> 
                                <td class="text-center"><h6><?= $models->strBien?$models->strInforme:'-' ?></h6></td>
                                <td class="text-center"><h6><?= $models->condicion?$models->condicion->descripcion:'-'?></h6></td>
                                <td class="text-center"><h6><?= $models->tipo_identificacion?$models->tipo_identificacion:'-'  ?></h6></td>
                                <td class="text-center"><h6><?= $models->usuarioAsignado?$models->usuarioAsignado->strAgente:'-'  ?></h6></td>
                            </tr>
                                <?php 
                                       }
                                    }
                                ?>
                             
                        </table>
                        
                        <br>
                     
                    <table width="100%" align="center" BORDER=1 CELLPADDING=5 CELLSPACING=0>
                         
                         <tr>
                         <th class="text-center" scope="col"> SOBRANTES                            </th>
                         <th class="text-center" scope="col">                                FALTANTES                           </th>
                         <th class="text-center" scope="col">                            OBSERVACIONES                           </th>

                     </tr>
                     <tr>
                     <td class="text-center"><h6><?=  $modelDependencia[0]->sobrantes ? $modelDependencia[0]->sobrantes: "-"  ?></h6></td> 
                     <td class="text-center"><h6><?=  $modelDependencia[0]->observaciones ? $modelDependencia[0]->observaciones: "-"  ?></h6></td> 
                     <td class="text-center"><h6><?=  $modelDependencia[0]->observaciones_admin ? $modelDependencia[0]->observaciones_admin: "-"  ?></h6></td> 

                     </tr>
                 </table>
                    </div>
                </div>
            </div>
        </div>
     
    </body>
</HTML>
