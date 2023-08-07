<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use patrimonio\models\BienUso;
use patrimonio\controllers\BienUsoController;
use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\controllers\ActaRecepcionController;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\controllers\ActaTransferenciaController;
use patrimonio\models\TrazabilidadBien;
use patrimonio\models\InformePatrimonial;
use patrimonio\parametros\PatrimonioDependencia;

/* @var $this yii\web\View */

$this->title = 'Patrimonio INV';

//datos bienes
$Bienes = BienUso::find()->where(['=', 'date(fecha_carga)',date('Y-m-d')])->andWhere(['!=','id_estado_interno',1])->all();
$biennuevas = count($Bienes);
$BienesP = BienUso::find()->where(['id_estado_interno'=>1])->all();
$biennuevasP = count($BienesP);
//datos acta recepcion
$ActasR = ActaRecepcionCabecera::find()->where(['=', 'date(fecha_carga)',date('Y-m-d')])->all();
$actaRnuevas = count($ActasR);
$ActasRP = ActaRecepcionCabecera::find()->where(['id_estado'=>2])->all();
$actaRnuevasP = count($ActasRP);
//datos trasferencia
$ActasT = ActaTransferenciaCab::find()->where(['=', 'date(fecha_carga)',date('Y-m-d')])->all();
$actaTnuevas = count($ActasT);
$ActasTP = ActaTransferenciaCab::find()->where(['id_estado_formulario'=>2])->andWhere(['fecha_baja'=>null])->all();
$actaTnuevasP = count($ActasTP);
//datos trazabilidad
$Traza = TrazabilidadBien::find()->where(['=', 'date(fecha_carga)',date('Y-m-d')])->all();
$trazaNew = count($Traza);
//datos informe
$informe = PatrimonioDependencia::find()->where(['=','id_estado_formulario', 6])->all();

$informeC=count($informe);
//->andWhere(['=', 'date(fecha)',date('Y-m-d')])
$perfil = '';
    $perfil = '';
    $busco_perfiles = Yii::$app->session->get('perfiles');
    //foreach ($_SESSION['perfiles'][1] as $roles){
    foreach ($busco_perfiles[17] as $roles){      
    //foreach ($_SESSION['perfiles'][1] as $roles){    
        $perfil = $perfil . '-' . $roles;
    } 

?>

<div class="site-index">

    <div  align='center'>
        <h1><i class="glyphicon glyphicon-book"></i>  Patrimonio INV</h1>
        
  
    </div>
</div>

<?php 
    if (strpos($perfil, 'Administrador')== 1 || strpos($perfil,'Consultor') == 1){
  ?>

    <div class="panel panel-primary" style="width:100%">
     
    <div class="panel-heading">
        <h4 class="panel-title" align="center">
            <i class="glyphicon glyphicon-bell"></i>
            Novedades
        </h4>
    </div>
    <div class="panel-body" align="center">
        <div class="row">
         </div> 
         <table> 
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=bien-uso/index">Bienes de Uso<?php echo" - ".($biennuevas)." "."Nuevos bienes"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=acta-recepcion-cabecera/index">Actas de Recepción<?php echo" - ".($actaRnuevas)." "."Nuevas actas"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                        <?php echo" - ".($actaRnuevasP)." "."Pendientes"." " ?>
                        <i class="glyphicon glyphicon-alert" style="color:red"></i></a></h4>
                    </td>
                </tr>
                   
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=acta-transferencia-cab/index">Trasferencias de Bienes<?php echo" - ".($actaTnuevas)." "."Nuevas actas"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                        <a href="index.php?r=acta-transferencia-cab%2Findex&ActaTransferenciaCabSearch%5Bid_dependencia%5D=&ActaTransferenciaCabSearch%5Bid_dependencia2%5D=&ActaTransferenciaCabSearch%5Btipo_solicitud%5D=&ActaTransferenciaCabSearch%5Bfecha_transferencia%5D=&ActaTransferenciaCabSearch%5Bid%5D=&ActaTransferenciaCabSearch%5Bid_estado_formulario%5D=2">Transferencias pendientes<?php echo" - ".($actaTnuevasP)." "."Pendientes"." " ?>
                        <i class="glyphicon glyphicon-alert" style="color:red"></i></a></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=trazabilidad-bien/index">Trazabilidad de Bienes<?php echo" - ".($trazaNew)." "."Nuevos movimientos"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i></a></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=informe-patrimonial%2Findex&InformePatrimonialSearch%5Bid_estado_formulario%5D=6&InformePatrimonialSearch%5Bid%5D=">Informe Patrimonial<?php echo" - ".($informeC)." "."Informes presentados"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i></a></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=amortizacion/index">Amortización
                        </a></h4>
                    </td>
                </tr>

         </table> 
    </div>
</div>
<div class="well" align="center">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-help"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><h4>Manual del sistema</h4></span>
          <span class="info-box-number"><a href="pdf/manual_sistema.pdf" target='_blank' class="small-box-footer"><small><h4> Leer  <i class="fa ion-ios-book-outline"></h4></small></i></a></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

<?php } 
    if (strpos($perfil, 'Agente')== 1 ){
  ?>
<div class="panel panel-primary" style="width:100%">
<div class="panel-heading">
    <h4 class="panel-title" align="center">
        <i class="glyphicon glyphicon-bell"></i>
        Novedades
    </h4>
</div>
<div class="panel-body" align="center">
    <div class="row">
     </div> 
     <table> 
            <tr>
                <td>
                <h4><i class="	glyphicon glyphicon-menu-right"></i>
                        <a href="index.php?r=bien-uso/index">Bienes de Uso<?php echo" - ".($biennuevas)." "."Nuevos bienes"." " ?>
                        <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                </td>
            </tr>
            <tr>
                <td>
                    <h4><i class="	glyphicon glyphicon-menu-right"></i>
                    <a href="index.php?r=acta-recepcion-cabecera/index">Actas de Recepción<?php echo" - ".($actaRnuevas)." "."Nuevas actas"." " ?>
                    <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                    <?php echo" - ".($actaRnuevasP)." "."Pendientes"." " ?>
                    <i class="glyphicon glyphicon-alert" style="color:red"></i></a></h4>
                </td>
            </tr>
                
            <tr>
                <td>
                    <h4><i class="	glyphicon glyphicon-menu-right"></i>
                    <a href="index.php?r=acta-transferencia-cab/index">Trasferencias de Bienes<?php echo" - ".($actaTnuevas)." "."Nuevas actas"." " ?>
                    <i class="	glyphicon glyphicon-flag" style="color:green"></i>
                    <?php echo" - ".($actaTnuevasP)." "."Pendientes"." " ?>
                    <i class="glyphicon glyphicon-alert" style="color:red"></i></a></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4><i class="	glyphicon glyphicon-menu-right"></i>
                    <a href="index.php?r=trazabilidad-bien/index">Trazabilidad de Bienes<?php echo" - ".($trazaNew)." "."Nuevos movimientos"." " ?>
                    <i class="	glyphicon glyphicon-flag" style="color:green"></i></a></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4><i class="	glyphicon glyphicon-menu-right"></i>
                    <a href="index.php?r=informe-patrimonial/index">Informe Patrimonial<?php echo" - ".($informeC)." "."Informes presentados"." " ?>
                    <i class="	glyphicon glyphicon-flag" style="color:green"></i></a></h4>
                </td>
            </tr>
            <!-- <tr>
                <td>
                    <h4><i class="	glyphicon glyphicon-menu-right"></i>
                    <a href="index.php?r=amortizacion/index">Amortización
                    </a></h4>
                </td>
            </tr> -->

     </table> 
</div>
</div>
<div class="well" align="center">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-help"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><h4>Manual del sistema</h4></span>
          <span class="info-box-number"><a href="pdf/manual_sistema.pdf" target='_blank' class="small-box-footer"><small><h4> Leer  <i class="fa ion-ios-book-outline"></h4></small></i></a></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

<?php }
if (strpos($perfil, 'Encargado')== 1 ){
?>

<div class="well" align="center">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-help"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><h4>Manual del sistema</h4></span>
          <span class="info-box-number"><a href="pdf/manual_encargados.pdf" target='_blank' class="small-box-footer"><small><h4> Leer  <i class="fa ion-ios-book-outline"></h4></small></i></a></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

<?php }
