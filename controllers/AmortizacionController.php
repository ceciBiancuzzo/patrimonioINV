<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\Amortizacion;
use patrimonio\models\search\AmortizacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use patrimonio\models\BienUso;
use patrimonio\parametros\PatrimonioRubro;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
//use patrimonio\models\SolicitudDet;
/**
 * AmortizacionController implements the CRUD actions for Amortizacion model.
 */
set_time_limit(0);
ini_set('memory_limit', '1500000M');
ini_set("pcre.backtrack_limit", "5000000"); 
class AmortizacionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Amortizacion models.
     * @return mixed
     */
    public function actionIndex() {
        set_time_limit(0);
        $searchModel = new AmortizacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexAmortizacion() {
        
        $searchModel = new AmortizacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_amortizacion', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Amortizacion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){
        {
            $model = $this->findModel($id);
    
            $searchModel = new AmortizacionSearch();
    
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }

            //a modificar
            $dataProvider= $searchModel->searchBienAmortizado($model->id_bien_uso,431);
            //$dataProvider= $searchModel->searchBienAmortizado($model->id_bien_uso,432);
            
            return $this->render('index_amortizacion', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'searchModel'=> $searchModel,

            ]);
        }
    }
    
        //metodo para crear nuevas solicitudes
        public function actionCreate()  {   
            set_time_limit(0);         
            $model = new Amortizacion();
            $idCab=null;
            //$bienes = $model->bienes;
            //$post = Yii::$app->request->post();
            if ($model->load(Yii::$app->request->post())){
                //$model->id_estado=1;
                //datos auditoria
                $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);   
                $model->setAttribute('fecha_carga',date('Y-m-d H:i:s'));
                //traigo los bienes
                $modelBienes = BienUso::find()
                ->orderBy('id ASC')->all(); 
             
                //creo las variables que voy a utilizar de temporales
                $anioActual=null;
                //comprubo si se ingreso un año en particular
                if($model->anio==null) {
                    if(date('m')<10){
                        $anioActual=date('Y')-1;
                        $model->anio= $anioActual;

                    }else{
                    $anioActual=date('Y');
                    $model->anio= $anioActual;
                    }
                }else {
                    $anioActual=$model->anio;  
                }/* 
                aa=amortizacion anual
                aatotal=amortizacion anual suma
                vut=vida util 
                residual=valor residual
                aaAcum=
                 */
                $aa=null;
                $aatotal=null;
                $vut=1;
                $aaAcum=null;
                $aaAcumAnterior=null;
                $residual=null;
                $precio_origen_total=null;
                $cantidad_bienes_amortizados=null;
                //$valor_residual_total=null;
                //compruebo que existan bienes
                if (count($modelBienes) > 0){
                    foreach ($modelBienes as $bien){
                        //compruebo que el estade los bienes no sean provisorios ni esten dados de bajao d
                       
                        if($bien->id_estado_interno>1 && $bien->id_estado_interno<5 && $bien->amortizable==true && $bien->precio_origen!=null && $bien->id_rubro!=null){
                            if($bien->anio_alta<=$anioActual){
                         
                                $modelRubro = PatrimonioRubro::find()->where(['id'=>$bien->id_rubro])->all();
                                 //   if ($modelRubro[0]->nro_anos_vida_util!=999&&$modelRubro[0]->nro_anos_vida_util!=0) {
                                    if ($bien->vida_util != null && $bien->vida_util != 0) {
                                    //calculo Amortizacion Anual    
                                    $aa=$bien->precio_origen/$bien->vida_util;
                                  
                                        if ($anioActual==$bien->anio_alta) {
                                            $vut=1;
                                            $aaAcum=$aa;
                                            $residual=$bien->precio_origen-$aaAcum;
                                            $aaAcumAnterior=0;
                                        }else{
                                            $vut=$anioActual-($bien->anio_alta)+1;
                                            $aaAcum=$aa*($vut);       
                                            $residual=$bien->precio_origen-$aaAcum;
                                            
                                        if ($vut>=2) {
                                            $aaAcumAnterior=0;
                                            $aaAcumAnterior=$aa*($vut-1);
                                        }if($vut<=1){
                                            $aaAcumAnterior=0;
                                        }
                                    }
                                    if ($residual<=0) {
                                        $residual=1;
                                        $aaAcum=$bien->precio_origen-1;
                                        $aa=0;
                                    }
                                    //calculo del año anterior

                                    //guardo los datos espesificos del bien solo si el calculo coinside con el año actual
                               // if ($model->anio == date('Y')) { ///LO COMENTE PORQUE ENTIENDO QUE ESTARIA DE MAS
                                //$bien->setAttribute('vida_util',$modelRubro[0]->nro_anos_vida_util);
                                $bien->setAttribute('vida_util_transcurrida',$vut);
                                $bien->setAttribute('amortizacion_anual_acumulada',$aaAcum);
                                $bien->setAttribute('amortizacion_anual',$aa);
                                $bien->setAttribute('valor_rezago',1);
                                $bien->setAttribute('valor_residual',$residual);
                               
                                $bien->save();
/*                                 if ($bien->anio_alta==2010) {
                                    echo "<pre>";
                                    print_r($bien);
                                    echo "</pre>";
                                    die();

                                } */
                                //no sumar los valores 1
                                if ($residual==1) {
                                    $residual=0;
                                }
                             //   }
                                $cantidad_bienes_amortizados++;
                                //compruebo el rubro y guardo los datos acumulativos
                                switch ($modelRubro[0]->codigo_presupuestario) {
                                    case 431:                                        
                                        $model->r_431=$model->getAttribute('r_431')+$aa;
                                        $model->r_431_acumulada=$model->getAttribute('r_431_acumulada')+$aaAcum;
                                        $model->r_431_precio_origen=$model->getAttribute('r_431_precio_origen')+$bien->precio_origen;
                                        $model->r_431_valor_residual=$model->getAttribute('r_431_valor_residual')+$residual;
                                        $model->r_431_amortizacion_acum_anterior=$model->getAttribute('r_431_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 432:
                                        $model->r_432=$model->getAttribute('r_432')+$aa;
                                        $model->r_432_acumulada=$model->getAttribute('r_432_acumulada')+$aaAcum;
                                        $model->r_432_precio_origen=$model->getAttribute('r_432_precio_origen')+$bien->precio_origen;
                                        $model->r_432_valor_residual=$model->getAttribute('r_432_valor_residual')+$residual;
                                        $model->r_432_amortizacion_acum_anterior=$model->getAttribute('r_432_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 433:
                                        $model->r_433=$model->getAttribute('r_433')+$aa;
                                        $model->r_433_acumulada=$model->getAttribute('r_433_acumulada')+$aaAcum;
                                        $model->r_433_precio_origen=$model->getAttribute('r_433_precio_origen')+$bien->precio_origen;
                                        $model->r_433_valor_residual=$model->getAttribute('r_433_valor_residual')+$residual;
                                        $model->r_433_amortizacion_acum_anterior=$model->getAttribute('r_433_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 434:
                                        $model->r_434=$model->getAttribute('r_434')+$aa;
                                        $model->r_434_acumulada=$model->getAttribute('r_434_acumulada')+$aaAcum;
                                        $model->r_434_precio_origen=$model->getAttribute('r_434_precio_origen')+$bien->precio_origen;
                                        $model->r_434_valor_residual=$model->getAttribute('r_434_valor_residual')+$residual;
                                        $model->r_434_amortizacion_acum_anterior=$model->getAttribute('r_434_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 435:
                                        $model->r_435=$model->getAttribute('r_435')+$aa;
                                        $model->r_435_acumulada=$model->getAttribute('r_435_acumulada')+$aaAcum;
                                        $model->r_435_precio_origen=$model->getAttribute('r_435_precio_origen')+$bien->precio_origen;
                                        $model->r_435_valor_residual=$model->getAttribute('r_435_valor_residual')+$residual;
                                        $model->r_435_amortizacion_acum_anterior=$model->getAttribute('r_435_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 436:
                                        $model->r_436=$model->getAttribute('r_436')+$aa;
                                        $model->r_436_acumulada=$model->getAttribute('r_436_acumulada')+$aaAcum;
                                        $model->r_436_precio_origen=$model->getAttribute('r_436_precio_origen')+$bien->precio_origen;
                                        $model->r_436_valor_residual=$model->getAttribute('r_436_valor_residual')+$residual;
                                        $model->r_436_amortizacion_acum_anterior=$model->getAttribute('r_436_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 437:
                                        $model->r_437=$model->getAttribute('r_437')+$aa;
                                        $model->r_437_acumulada=$model->getAttribute('r_437_acumulada')+$aaAcum;
                                        $model->r_437_precio_origen=$model->getAttribute('r_437_precio_origen')+$bien->precio_origen;
                                        $model->r_437_valor_residual=$model->getAttribute('r_437_valor_residual')+$residual;
                                        $model->r_437_amortizacion_acum_anterior=$model->getAttribute('r_437_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 438:
                                        $model->r_438=$model->getAttribute('r_438')+$aa;
                                        $model->r_438_acumulada=$model->getAttribute('r_438_acumulada')+$aaAcum;
                                        $model->r_438_precio_origen=$model->getAttribute('r_438_precio_origen')+$bien->precio_origen;
                                        $model->r_438_valor_residual=$model->getAttribute('r_438_valor_residual')+$residual;
                                        $model->r_438_amortizacion_acum_anterior=$model->getAttribute('r_438_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    case 439:
                                        $model->r_439=$model->getAttribute('r_439')+$aa;
                                        $model->r_439_acumulada=$model->getAttribute('r_439_acumulada')+$aaAcum;
                                        $model->r_439_precio_origen=$model->getAttribute('r_439_precio_origen')+$bien->precio_origen;
                                        $model->r_439_valor_residual=$model->getAttribute('r_439_valor_residual')+$residual;
                                        $model->r_439_amortizacion_acum_anterior=$model->getAttribute('r_439_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                  case 481:
                                        $model->r_481=$model->getAttribute('r_481')+$aa;
                                        $model->r_481_acumulada=$model->getAttribute('r_481_acumulada')+$aaAcum;
                                        $model->r_481_precio_origen=$model->getAttribute('r_481_precio_origen')+$bien->precio_origen;
                                        $model->r_481_valor_residual=$model->getAttribute('r_481_valor_residual')+$residual;
                                        $model->r_481_amortizacion_acum_anterior=$model->getAttribute('r_481_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                  case 411:
                                        $model->r_411=$model->getAttribute('r_411')+$aa;
                                        $model->r_411_acumulada=$model->getAttribute('r_411_acumulada')+$aaAcum;
                                        $model->r_411_precio_origen=$model->getAttribute('r_411_precio_origen')+$bien->precio_origen;
                                        $model->r_411_valor_residual=$model->getAttribute('r_411_valor_residual')+$residual;
                                        $model->r_411_amortizacion_acum_anterior=$model->getAttribute('r_411_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                  case 412:
                                        $model->r_412=$model->getAttribute('r_412')+$aa;
                                        $model->r_412_acumulada=$model->getAttribute('r_412_acumulada')+$aaAcum;
                                        $model->r_412_precio_origen=$model->getAttribute('r_412_precio_origen')+$bien->precio_origen;
                                        $model->r_412_valor_residual=$model->getAttribute('r_412_valor_residual')+$residual;
                                        $model->r_412_amortizacion_acum_anterior=$model->getAttribute('r_412_amortizacion_acum_anterior')+$aaAcumAnterior;
                                            break;
                                    default:
                                  //  print_r($modelRubro);die;
                                    echo "<script>console.log('error de rubro' );</script>";
                                        break;
                                }
                                //ahora queda hacer un metodo que elija en que columna guardar el dato de acumulacion de aa 
                                        }  
                                    }    
                                }
                            }
                        }
                    
                    //sumo los valores totales
                $precio_origen_total=$model->r_431_precio_origen+$model->r_432_precio_origen+$model->r_433_precio_origen+$model->r_434_precio_origen+$model->r_435_precio_origen+$model->r_436_precio_origen+$model->r_437_precio_origen+$model->r_438_precio_origen+$model->r_439_precio_origen+$model->r_481_precio_origen+$model->r_411_precio_origen+$model->r_412_precio_origen;
                $residual=($model->r_431_valor_residual+$model->r_432_valor_residual+$model->r_434_valor_residual+$model->r_433_valor_residual+$model->r_435_valor_residual+$model->r_436_valor_residual+$model->r_437_valor_residual+$model->r_438_valor_residual+$model->r_439_valor_residual+$model->r_481_valor_residual+$model->r_411_valor_residual+$model->r_412_valor_residual);
                $aatotal=$model->r_439+$model->r_481+$model->r_438+$model->r_437+$model->r_436+$model->r_435+$model->r_434+$model->r_432+$model->r_431+$model->r_433+$model->r_411+$model->r_412;
                $aaAcumAnterior=$model->r_411_amortizacion_acum_anterior+$model->r_412_amortizacion_acum_anterior+$model->r_431_amortizacion_acum_anterior+$model->r_412_amortizacion_acum_anterior+$model->r_411_amortizacion_acum_anterior+$model->r_481_amortizacion_acum_anterior+$model->r_432_amortizacion_acum_anterior+$model->r_433_amortizacion_acum_anterior+$model->r_434_amortizacion_acum_anterior+$model->r_435_amortizacion_acum_anterior+$model->r_436_amortizacion_acum_anterior+$model->r_437_amortizacion_acum_anterior+$model->r_438_amortizacion_acum_anterior+$model->r_439_amortizacion_acum_anterior;
                $aaAcum=$model->r_411_acumulada+$model->r_412_acumulada+$model->r_439_acumulada+$model->r_481_acumulada+$model->r_438_acumulada+$model->r_437_acumulada+$model->r_436_acumulada+$model->r_435_acumulada+$model->r_434_acumulada+$model->r_432_acumulada+$model->r_431_acumulada+$model->r_433_acumulada;
                //print_r()
                $model->setAttribute('cantidad_bienes_amortizados',$cantidad_bienes_amortizados);
                $model->setAttribute('precio_origen_total',$precio_origen_total);
                $model->setAttribute('amortizacion_anual',$aatotal);
                $model->setAttribute('amortizacion_anual_acumulada',$aaAcum);
                $model->setAttribute('valor_residual',$residual);
                $model->setAttribute('amortizacion_acum_anterior',$aaAcumAnterior);
                $model->save();
                $idCab = $model->getAttribute('id');
                
                return $this->redirect(['index', 'id' => $idCab]);
            }
    
            return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);

        }


        
    
    /**
     * Updates an existing Amortizacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $searchModel = new AmortizacionSearch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        $dataProvider = $searchModel->searchBienAmortizado($model->id_bien_uso);

        return $this->render('index_amortizacion', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'searchModel'=> $searchModel,

        ]);
    }

    public function actionPrint($id){
      
        $model = $this->findModel($id);
       
        $titulo = "Amortizacion";
                $content = $this->renderPartial('print',['model'=>$model]);
        $pdf = new Pdf([
                        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                        'content' => $content,
                        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                        'cssInline' => '.table td{font-size:11px}', 
                        'format' => Pdf::FORMAT_A4,
                        'orientation' => 'L',
                        //'options' => ['title' => "Evaluacion ",
                        'options' =>    [
                                            'title' => $titulo,
                                            //'subject' => $titulo,
                                        ],
                        
                         ]);

        $response = Yii::$app->response;

        $response->format = \yii\web\Response::FORMAT_RAW;

        $headers = Yii::$app->response->headers;

        $headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    } 
    public function actionExportExcelAmortizaciones() {
        $searchModel = new AmortizacionSearch();
        $print = false;
        $dataProvider = $searchModel->searchExcel431(Yii::$app->request->queryParams);  
        if($dataProvider->getTotalCount() < 1){
            Yii::$app->getSession()->setFlash('error', 'No existen datos con los filtros aplicados');
            return $this->redirect(['index']);
        }
 
        //print_r($dataProvider);
        //die;          
        //Le mando la variable export para 
        
        // for($i=0;$i<$dataProvider->getTotalCount();$i++){
        //    // print_r($dataProvider);
        //     $fila = $dataProvider->getModels()[$i];
        //     print_r($fila);
        //     print_r("<br>");
        // }
        // die();
        
    // $datos = $searchModel->searchImprimir(Yii::$app->request->queryParams,$print);
    // $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $datos]);
        //return $this->render('index',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'export'=>$export]);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="BienesDeUso.xlsx"');
        header('Cache-Control: max-age=0');
        $spread = new Spreadsheet();
        $spread
        ->getProperties()
        ->setCreator("Patrimonio")
        ->setLastModifiedBy('Sistema Gestion INV')
        ->setTitle('Excel creado con PhpSpreadSheet')
        ->setSubject('Bienes de uso')
        ->setDescription('Excel de bienes de uso');
        $sheet = $spread->getActiveSheet();
        $sheet->setCellValue("A1", "RUBRO");
        $sheet->setCellValue("B1", "NÚMERO DE INVENTARIO");
        $sheet->setCellValue("C1", "DESCRIPCIÓN BIEN");
        $sheet->setCellValue("D1", "AÑO DE ALTA");
        $sheet->setCellValue("E1", "PRECIO DE ORIGEN");
        $sheet->setCellValue("F1", "VALOR REZAGO");
        $sheet->setCellValue("G1", "VIDA ÚTIL");
        $sheet->setCellValue("H1", "VIDA UTIL TRANSCURRIDA");
        $sheet->setCellValue("I1", "AMORTIZACION ANUAL");
        $sheet->setCellValue("J1", "AMORTIZACION ANUAL ACUMULADA");
        $sheet->setCellValue("K1", "VALOR RESIDUAL");
 
        
        //$sheet->setCellValue("A2", "pepe");
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(20,'px');
        $sheet->getColumnDimension('B')->setWidth(15,'px');
        $sheet->getColumnDimension('C')->setWidth(40,'px');
        $sheet->getColumnDimension('D')->setWidth(15,'px');
        $sheet->getColumnDimension('E')->setWidth(10,'px');
        $sheet->getColumnDimension('F')->setWidth(15,'px');
        $sheet->getColumnDimension('G')->setWidth(15,'px');
        $sheet->getColumnDimension('H')->setWidth(15,'px');
        $sheet->getColumnDimension('I')->setWidth(15,'px');
        $sheet->getColumnDimension('J')->setWidth(10,'px');
        $sheet->getColumnDimension('K')->setWidth(25,'px');
        $sheet->getColumnDimension('L')->setWidth(25,'px');

        


        if($dataProvider->getTotalCount() > 0){
            $fila=1;
            //while ($row = pg_fetch_array($dataProvider)){/
            for($i=0;$i<$dataProvider->getTotalCount();$i++){
                $linea = $dataProvider->getModels()[$i];

                $fila ++;
                //$sheet->setCellValueByColumnAndRow(1, $fila, "hola");
                // $sheet->setCellValue("A".$fila, strval($linea['coddel_actuante']).' - '.$linea['desdele']);
                $sheet->setCellValue("A".$fila, strval($linea['codigo_presupuestario']));
                $sheet->setCellValue("B".$fila, strval($linea['nro_inventario']));
                $sheet->setCellValue("C".$fila, strval($linea['descripcion_bien']));
                $sheet->setCellValue("D".$fila, strval($linea['anio_alta']));
                $sheet->setCellValue("E".$fila, strval($linea['precio_origen']));
                $sheet->setCellValue("F".$fila, strval($linea['valor_rezago']));
                $sheet->setCellValue("G".$fila, strval($linea['vida_util']));
                $sheet->setCellValue("H".$fila, strval($linea['vida_util_transcurrida']));
                $sheet->setCellValue("I".$fila, strval($linea['amortizacion_anual']));
                $sheet->setCellValue("J".$fila, strval($linea['amortizacion_anual_acumulada']));
                $sheet->setCellValue("K".$fila, strval($linea['valor_residual']));


                //$sheet->setCellValue("A2", "HOLA");
            }
        }else{
            $sheet->setCellValue("A2","NO HAY DATOS PARA MOSTRAR CON LOS FILTROS APLICADOS ");
        }
        
        $writer = IOFactory::createWriter($spread, 'Xlsx');
        $writer->save('php://output');
        exit;
        
}
    /**
     * Deletes an existing Amortizacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $model = $this->findModel($id);

        $model->setAttribute('fecha_baja',date('Y-m-d H:i:s'));
        $model->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
        $model->save();
        //$model->delete();
        Yii::$app->getSession()->setFlash('success', 'La amortización se elimino correctamente.');           
    
        return $this->redirect(['index']);        
    }

    /**
     * Finds the Amortizacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Amortizacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)  {
        if (($model = Amortizacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

