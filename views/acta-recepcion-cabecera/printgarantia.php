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
$archivo = $url;
$script = <<< JS


  
    
    window.open('garantias/$url');
    

  

   
JS;
$this->registerJs($script);

?>
