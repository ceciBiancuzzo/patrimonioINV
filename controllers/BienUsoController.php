<?php

namespace patrimonio\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use patrimonio\models\BienUso;
use patrimonio\models\TrazabilidadBien;
use patrimonio\controllers\TrazabilidadBienController;
use patrimonio\models\BienUsoContables;
use patrimonio\models\BienUsoGarantia;
use patrimonio\models\BienUsoSeguro;
use patrimonio\models\PatrimonioImagenBien;
use patrimonio\parametros\PatrimonioMarca;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\models\search\BienUsoSearch;
use gestion_personal\models\PersonalOrganigrama;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\FileUpload;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
 * BienUsoController implements the CRUD actions for BienUso model.
 */
set_time_limit(0);
ini_set('memory_limit', '1500000M');
ini_set("pcre.backtrack_limit", "5000000"); 
class BienUsoController extends Controller
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
     * Lists all BienUso models.
     * @return mixed
     */
    public function actionIndex()
    {
        set_time_limit(0);
        $searchModel = new \patrimonio\models\search\BienUsoSearch();
        $params = Yii::$app->request->queryParams; 
        
        if(count($params) > 1){
            $page = isset($params['page']) ? $params['page'] : 1;
            $size = isset($params['per-page']) ? $params['per-page'] : 10;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            //$total=CosechaCiuVista::getTotalInicios($dataProvider,$page,$size);
            //list($partes_presentados, $cantidad_inscriptos) = array_pad(explode('/', "$total "),2,null);
        }else{
            $datos = [];
            $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $datos,]);
            //$searchModel->codigo_delegacion = Yii::$app->user->identity->delegacion->codigo_delegacion;
         }
       //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexDetalle() {
        
        // $model = new BienUso();
        
        $get = Yii::$app->request->get();
       
        $dataProviderDetalle = new \yii\data\ArrayDataProvider([
            'allModels' => [],
        ]);
        // print_r($get);die();
        if ($get != null) {
                  $model = BienUso::find()
                  ->where(['id' => $get['id']]) ->one();
                      

           $queryContables = BienUsoContables::find()->where(['id_bien_uso' => $get['id']])
           ->andWhere(['fecha_baja' => null]);
           
           $queryGarantia = BienUsoGarantia::find()->where(['id_bien_uso' => $get['id']])
           ->andWhere(['fecha_baja' => null]);
           $querySeguro = BienUsoSeguro::find()->where(['id_bien_uso' => $get['id']])
           ->andWhere(['fecha_baja' => null]);
            $dataProviderContables = new ActiveDataProvider([
                'query' => $queryContables,
            ]);
            $dataProviderGarantia = new ActiveDataProvider([
                'query' => $queryGarantia,
            ]);
            $dataProviderSeguro = new ActiveDataProvider([
                'query' => $querySeguro,
            ]);
        }

        return $this->render('index_detalle', [
            'model'=>$model,
            'dataProviderContables' => $dataProviderContables,'dataProviderGarantia'=>$dataProviderGarantia, 'dataProviderSeguro'=>$dataProviderSeguro
        ]);
    }
 /**
     * Displays a single BienUso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('index', [
            'model' => $this->findModel($id),
        ]);
    }

  
    /**
     * Creates a new ActaRecepcionCabecera model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()  {            

        $model = new BienUso();
        $modelMarca= new PatrimonioMarca();
        $idCab=null;
        $post = Yii::$app->request->post();
            if ($model->load(Yii::$app->request->post())){
      
                $model->id_estado_interno=1;
                $model->id_condicion=1;
                $model->id_estado_formulario = 1;
                $model->vida_util=$model->rubro->nro_anos_vida_util;
                $model->amortizable = true;
                $model->faltante = false;
                $model->anio_alta= date('Y');
                $model->modelo = $post['BienUso']['modelo'];
                $model->descripcion_bien = $post['BienUso']['descripcion_bien'];
                $model->id_dependencia = $post['BienUso']['id_dependencia'];
                $model->id_usuario_carga= Yii::$app->user->identity->id;
                $model->fecha_carga=date('Y-m-d H:m:s'); 

                $modelTrazabilidad = new TrazabilidadBien();

                
                $modelTrazabilidad->id_estado=$model->id_estado_interno;
                
                $modelTrazabilidad->id_condicion=$model->id_condicion;
                
                $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;

                $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;

                $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 

                $modelTrazabilidad->id_usuario_actual=$model->id_usuario_bien;
                
                $modelTrazabilidad->id_area_actual=$model->id_dependencia;

                $modelTrazabilidad->tipo_movimiento ="Ingreso provisorio";
                /* $model->id_detalle_acta=1;
                echo "<pre>";
                print_r($model->id_detalle_acta);
                echo "</pre>";
                die(); */
                $model->save();
                $modelTrazabilidad->id_bien_uso=$model->id;
                $modelTrazabilidad->save();
                $idCab = $model->id;
          
                return $this->redirect(['index-detalle', 'id' => $idCab]);
            }
    
            
                
            //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_bien_uso
        
            return $this->render('_form', [
                'model' => $model,
                //'model' => $modelMarca,

            ]);
        }
    public function actionCreateMarca()
    {
        $modelMarca = new PatrimonioMarca();

        if ($modelMarca->load(Yii::$app->request->post())) {
            $modelMarca->save();
        }

        return $this->render('_form', [
            'model' => $modelMarca,
        ]);
    }
    public function actionCargaSerie($id){
        $model =$this->findModel($id);
        $get = Yii::$app->request->get(); 
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['index']);        

        }

        
        return $this->render('carga_serie', [ 'model' => $model]);
    }

    public function actionCreateDetallesContables($id_bien_uso)
    {
        $model = new BienUsoContables();
        $model->id_bien_uso=$id_bien_uso;
        $get = Yii::$app->request->get(); 
        // print_r($model);
        //     die();    
        if ($model->load( $post = Yii::$app->request->post())) { 
                  
            $idDet = null;
            $idCab = null;        
            
            if ($model->id_bien_uso != null) { 
            //    $model->id = $model->getAttribute('id_bien_uso');
            
            
            if ($model->id != null) {
                        
                $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_modificacion',date('Y-m-d H:m:s'));      
                
                // $model->setScenario(\chsergey\rest\Model::SCENARIO_UPDATE);
            }else{
                 
                $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_carga',date('Y-m-d H:m:s'));    
                //  $model->setScenario(\chsergey\rest\Model::SCENARIO_CREATE);
            }          
                   
                    $model->save();
                    // $model1= BienUso();
                    $idCab = $model->getAttribute('id_bien_uso');
                    return $this->redirect(['index-detalle', 'id' => $idCab]);
            }            
        } 
        return $this->renderAjax('form_detalles_contables', [ 'model' => $model, 'modo' => '']);
    }
    
    public function actionUpdateDetallesContables($id){

        $model= $this->findModelDetallesContables($id);
        if ($model->load( $post = Yii::$app->request->post())) { 
            $model->id_usuario_modificacion= Yii::$app->user->identity->id;
            $model->fecha_modificacion=date('Y-m-d H:m:s');
            $model->save();
            //$idCab=$model->getAttribute('id_bien_uso');
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalles_contables', [ 'model' => $model, 'modo' => '']);
        }
    }
    public function actionCreateDetallesGarantia($id_bien_uso)
    {
        $model = new BienUsoGarantia();
        $model->id_bien_uso=$id_bien_uso;
        $get = Yii::$app->request->get(); 
        // print_r($model);
        //     die();    
        if ($model->load( $post = Yii::$app->request->post())) { 
                  
            $idDet = null;
            $idCab = null;        
            
            if ($model->id_bien_uso != null) { 
            //    $model->id = $model->getAttribute('id_bien_uso');
            
            
            if ($model->id != null) {
                        
                $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_modificacion',date('Y-m-d H:m:s'));      
                
                // $model->setScenario(\chsergey\rest\Model::SCENARIO_UPDATE);
            }else{
                 
                $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_carga',date('Y-m-d H:m:s'));    
                //  $model->setScenario(\chsergey\rest\Model::SCENARIO_CREATE);
            }          
                   
                    $model->save();
                    // $model1= BienUso();
                    $idCab = $model->getAttribute('id_bien_uso');
                    return $this->redirect(['index-detalle', 'id' => $idCab]);
            }            
        } 
        return $this->renderAjax('form_detalles_garantia', [ 'model' => $model, 'modo' => '']);
    }
    
    
    public function actionUpdateDetallesGarantia($id){

        $model= $this->findModelDetallesGarantia($id);
        if ($model->load( $post = Yii::$app->request->post())) { 
            $model->id_usuario_modificacion= Yii::$app->user->identity->id;
            $model->fecha_modificacion=date('Y-m-d H:m:s');
            $model->save();
            //$idCab=$model->getAttribute('id_bien_uso');
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalles_garantia', [ 'model' => $model, 'modo' => '']);
        }
    }
    public function actionCreateDetallesSeguro($id_bien_uso)
    {
        $model = new BienUsoSeguro();
        $model->id_bien_uso=$id_bien_uso;
        $get = Yii::$app->request->get(); 
        // print_r($model);
        //     die();    
        if ($model->load( $post = Yii::$app->request->post())) { 
                  
            $idDet = null;
            $idCab = null;        
            
            if ($model->id_bien_uso != null) { 
            //    $model->id = $model->getAttribute('id_bien_uso');
            
            
            if ($model->id != null) {
                        
                $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_modificacion',date('Y-m-d H:m:s'));      
                
                // $model->setScenario(\chsergey\rest\Model::SCENARIO_UPDATE);
            }else{
                 
                $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);             
                $model->setAttribute('fecha_carga',date('Y-m-d H:m:s'));    
                //  $model->setScenario(\chsergey\rest\Model::SCENARIO_CREATE);
            }          
                   
                    $model->save();
                    // $model1= BienUso();
                    $idCab = $model->getAttribute('id_bien_uso');
                    return $this->redirect(['index-detalle', 'id' => $idCab]);
            }            
        } 
        return $this->renderAjax('form_detalles_seguro', [ 'model' => $model, 'modo' => '']);
    }
    
    public function actionUpdateDetallesSeguro($id){

        $model= $this->findModelDetallesSeguro($id);
        if ($model->load( $post = Yii::$app->request->post())) { 
            $model->id_usuario_modificacion= Yii::$app->user->identity->id;
            $model->fecha_modificacion=date('Y-m-d H:m:s');
            $model->save();
            //$idCab=$model->getAttribute('id_bien_uso');
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalles_seguro', [ 'model' => $model, 'modo' => '']);
        }
    }
    


    /**
     * Updates an existing BienUso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
        

        //return $this->redirect(['index-detalle', 'id' => $id]);

         $model = $this->findModel($id);
        
         if ($model->load(Yii::$app->request->post())){
            //$model = $this->findModel($id);
            $post = Yii::$app->request->post();
            
            $model->fecha_modificacion = date('Y-m-d');
            $model->id_usuario_modificacion = Yii::$app->user->identity->id;
            $model->id_dependencia = $post['BienUso']['id_dependencia'];    
            $model->id_estado_interno = $post['BienUso']['id_estado_interno'];    
            $model->id_condicion = $post['BienUso']['id_condicion'];    
            $model->codigo_item_catalogo = $post['BienUso']['codigo_item_catalogo'];    
            $model->tipo_identificacion = $post['BienUso']['tipo_identificacion'];
            $model->propiedad_bien = $post['BienUso']['propiedad_bien'];
            $model->faltante = $post['BienUso']['faltante'];
            $model->acto_admin = $post['BienUso']['acto_admin'];
            $model->obvs_admin = $post['BienUso']['obvs_admin'];
            $model->observaciones = $post['BienUso']['observaciones'];

     
            if($model->id_estado_interno == 1){
                $model->modelo = $post['BienUso']['modelo'];    
                $model->id_marca = $post['BienUso']['id_marca'];    
                $model->descripcion_bien = $post['BienUso']['descripcion_bien']; 
                $model->id_rubro = $post['BienUso']['id_rubro']; 
                $model->tipo_bien = $post['BienUso']['tipo_bien']; 


            }
            
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_estado=$model->id_estado_interno;
            $modelTrazabilidad->id_condicion=$model->id_condicion;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            $modelTrazabilidad->id_usuario_actual=$model->id_usuario_bien;
            $modelTrazabilidad->id_area_actual=$model->id_dependencia;
            $modelTrazabilidad->tipo_movimiento ="Modificacion de los datos del bien";
            $modelTrazabilidad->id_bien_uso=$model->id;

            $modelTrazabilidad->save();
            $model->save();
            $idCab = $model->getAttribute('id');
            return $this->redirect(['index']);    
            //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_bien_us
        }   

         
            $get = Yii::$app->request->get();
            $dataProviderDetalle = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);

        if ($get != null && isset($get['id'])) {

            $model = BienUso::find()
                  ->where(['id' => $get['id']]) ->one();
                  //->innerJoin([
                    //'bienUsoDetallesContables'])
                    //print_r($model);die();


           $queryContables = BienUsoContables::find()->where(['id_bien_uso' => $get['id']]);
           //->andWhere(['fecha_baja' => null]);
           
           $queryGarantia = BienUsoGarantia::find()->where(['id_bien_uso' => $get['id']]);
           //->andWhere(['fecha_baja' => null]);
           $querySeguro = BienUsoSeguro::find()->where(['id_bien_uso' => $get['id']]);
           //->andWhere(['fecha_baja' => null]);
            $dataProviderContables = new ActiveDataProvider([
                'query' => $queryContables,
            ]);
            $dataProviderGarantia = new ActiveDataProvider([
                'query' => $queryGarantia,
            ]);
            $dataProviderSeguro = new ActiveDataProvider([
                'query' => $querySeguro,
            ]);
        }

          return $this->render('index_detalle', [
           'model' => $model,   
           'dataProviderContables' => $dataProviderContables,'dataProviderGarantia'=>$dataProviderGarantia, 'dataProviderSeguro'=>$dataProviderSeguro
          ]);          


          

    }
    /**
     * Deletes an existing BienUso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        
        //Esto no esta funcionando, voy a empezar al reves aca arriba
        $model = $this->findModel($id);
        // $modelDet= new ActaTransferenciaDet;
        // $idDet= $modelDet->getAttribute('id');
        if($model->id_estado_interno == 1 || $model->id_estado_interno == 18){
        $fecha_hora_baja = date('Y-m-d H:i:s'); 
        $flag_detalle =true; 
        //$model = ->delete();
        
        
        $contables= $model->detallesContables;
        if($contables != null){
            foreach($contables as $detalle){
                $detalle->fecha_baja = $fecha_hora_baja;
                $detalle->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
                $flag_detalle=$detalle->save();
                if(!$flag_detalle){
                    break;  
                }
            }
        }

        $garantia= $model->detallesGarantia;
        
        if($garantia != null){
            foreach($garantia as $detalle){
                $detalle->fecha_baja = $fecha_hora_baja;
                $detalle->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
                $flag_detalle=$detalle->save();
                if(!$flag_detalle){
                    break;  
                }
            }
        }

        $seguro= $model->detallesSeguro;
        if($seguro != null){

            foreach($seguro as $detalle){
                $detalle->fecha_baja = $fecha_hora_baja;
                $detalle->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
                $flag_detalle=$detalle->save();
                if(!$flag_detalle){
                    break;  
                }
            }
        }
        $model->setAttribute('fecha_baja',date('Y-m-d H:i:s'));
        $model->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
        $model->save();
        //$model->delete();
        Yii::$app->getSession()->setFlash('success', 'Se eliminó  la el bien!!');           
    
        return $this->redirect(['index']);    
        }else{
            Yii::$app->getSession()->setFlash('danger', 'No se pudo eliminar el bien por su estado interno');           
    
            return $this->redirect(['index']);   
        }
    }
    public function actionDeleteDetallesSeguro($id) {
        $model = $this->findModelDetallesSeguro($id);
        //$model = ->delete();
        
        //if ($model->load( $post = Yii::$app->request->post())) { 
        if($id!=null){
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $model->save();
           
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
        }     
    }
    public function actionDeleteDetallesContables($id) {
       
        $model = $this->findModelDetallesContables($id);
        //$model = ->delete();
     
       // if ($model->load( $post = Yii::$app->request->post())) { 
           if($id!=null){
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $model->save();
           
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalles_contables', [ 'model' => $model, 'modo' => '']);
        }     
    }
    public function actionDeleteDetallesGarantia($id) {
        $model = $this->findModelDetallesGarantia($id);
        //$model = ->delete();
        
        // if ($model->load( $post = Yii::$app->request->post())) { 
        if($id!=null){
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $model->save();
           
            return $this->redirect(['index-detalle', 'id' => $model->id_bien_uso]);
        }else{
           return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
        }     
    }
    public function actionPrint($id){
      
        $model = $this->findModel($id);
       
        //$model = $this->findModelDetalle($id);
        //print_r($model);die;
        $titulo = "Bien de uso";
                $content = $this->renderPartial('print',['model'=>$model]);
        $pdf = new Pdf([
                        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                        'content' => $content,
                        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                        'cssInline' => '.table td{font-size:11px}', 
                        'format' => Pdf::FORMAT_A4,
                        //'orientation' => 'L',
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
    public function actionUploadFile($id = NULL) {
        $get = Yii::$app->request->get();
        $modelBien= new BienUso();
        $model = new FileUpload();
        $post = Yii::$app->request->post();

        $accion = '';
        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $model->load(Yii::$app->request->post('FileUpload'));
            

            
                //guardo foto
               // $imagenBien = $post['BienUso']['imagen_bien'];
                $id = $post['BienUso']['id'];


                $archivos = \yii\web\UploadedFile::getInstances($model, 'file'); //saco todos los datos nane,tempname, type,size, error

                if (!is_null($archivos)) {
                    foreach($archivos as $archivo){
                    //armo la imagen
                    $name = $archivo->name; // obtengo el nombre limpio
                    $explode = explode(".", $name); //el nombre y el png o jpg
                    $ext = end($explode); //obtengo el tipo solamente png o jpg
                    //$serverName = $id.''.$name.''.".{$ext}";
                    $serverName = $id.''.$name;
                    if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'jpeg') {
//
                        $byte = $archivo->size; //obtengo el tamaño
                        $kyloByte = $byte * 0.000977; // convierto a kb
                        //pregunto si supera el maximo de 500kb
                        if ($kyloByte > 500) {
                            $modelBien = BienUso::findOne($id);
                            Yii::$app->getSession()->setFlash('error', 'El tamaño del archivo es muy grande (NO DEBE SUPERAR LOS 500 kb)');
                            $this->redirect(['index-detalle', 'id' => $modelBien->id]);
                        }

                        //armo el modelo de la etiquet
                        //busco el id de la ultima etiqueta

                        //buscar el orden de la ultima etiqueta de esta marca
                        $imagen = new PatrimonioImagenBien();
                        
                       

                    
                      
                        // //armo la ruta del archivo

                        $path = dirname(__DIR__) . "/web/fotos/$serverName";
                        $imagen->setAttribute('id_bien_uso',$id);

                        $imagen->setAttribute('ruta_archivo',$serverName);
                        $imagen->setAttribute('imagen_bien',$serverName);

                        $imagen->save();
                        $idImagen = $imagen->id;
                        $bien = BienUso::find()
                        ->where(['id' => $id])
                        ->one();
                       
                        $bien->setAttribute('id_imagen', $idImagen);
                    
                        $archivo->saveAs($path);
                        //armo el modelo de la etiquet
                        $bien->setAttribute('ruta_archivo', $serverName);

                        $datos = array();
                        //$datos = getimagesize(Yii::$app->params['pathUploadFiles']);
                        $datos=getimagesize($path);
                        $ancho = $datos[0];
                        $alto = $datos[1];
                        $canal = $datos['channels'];

                        if ((int) $canal == 4) {
                            $modelBien = BienUso::findOne($imagenBien);
                            Yii::$app->getSession()->setFlash('error', 'LA IMAGEN TIENE UNA RESOLUCION MAS GRANDE DE LA PERMITIDA - MODIFIQUELA E INTENTE NUEVAMENTE');
                            $this->redirect(['index-detalle', 'id' => $bien->id]);
                        }


                        $bien->save();
                    
                    

                      
                    } else {
                        $modelBien = BienUso::findOne($imagen_bien);
                        Yii::$app->getSession()->setFlash('error', 'El archivo no tiene la extension requerida JPG');
                        $this->redirect(['index-detalle', 'id' => $bien->id]);
                    }
                }
                    Yii::$app->getSession()->setFlash('success', 'Se agrego la imagen correspondiente');
                    $this->redirect(['index-detalle', 'id' => $bien->id]);
                    
                }
            
        } else {
           
            $modelBien = new BienUso();
             $modelBien->setAttribute('id', $id);
      
            return $this->renderAjax('form_imagen', [
                        'model' => $modelBien,
                        'modelFile'=>$model,

            ]);
        }
    }
    public function actionVerImagen($id) {

      
        $modeloBien = BienUso::findOne($id);
   
        $imagenes = PatrimonioImagenBien::find()
        ->where(['id_bien_uso'=>$id])
        ->andWhere(['fecha_baja'=>null])->all();
        
        return $this->renderAjax('ver_imagen', [
                    'modelImagenes' => $imagenes,
        ]);
    }
   
    public function actionEliminarImagen($id) {


        if ($id != NULL) {
            $post = Yii::$app->request->post();

            if ($post != null) {
                $buscoEtiqueta = PatrimonioImagenBien::findOne($id);
                $modeloMarca = BienUso::findOne($buscoEtiqueta->id_bien_uso);
                $idbien = $modeloMarca->id;
                \Yii::trace(  $modeloMarca->id);
                 $buscoEtiqueta->setAttribute('fecha_baja', date('Y-m-d H:i:s'));
                // $buscoEtiqueta->setAttribute('id_usuario_baja', $_SESSION['id_persona']);

                $buscoEtiqueta->save();

              
               
                    Yii::$app->getSession()->setFlash('success', 'La etiqueta ha sido eliminada');
                    $this->redirect(['index-detalle', 'id' => $idbien]);
             
            }
        }
    }
    public function actionExportExcelBienes() {
       
        $searchModel = new BienUsoSearch();
        $print = false;
        $dataProvider = $searchModel->searchExcel(Yii::$app->request->queryParams);  
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
        $sheet->setCellValue("A1", "NÚMERO DE INVENTARIO");
        $sheet->setCellValue("B1", "CODIGO PRESUPUESTARIO");
        $sheet->setCellValue("C1", "DESCRIPCIÓN");
        $sheet->setCellValue("D1", "PRECIO DE ORIGEN");
        $sheet->setCellValue("E1", "VIDA ÚTIL");
        $sheet->setCellValue("F1", "AMORTIZACIÓN ANUAL");
        $sheet->setCellValue("G1", "VIDA ÚTIL TRANSCURRIDA");
        $sheet->setCellValue("H1", "VALOR RESIDUAL");
        $sheet->setCellValue("I1", "VALOR REZAGO");
        $sheet->setCellValue("J1", "AÑO ALTA");
        $sheet->setCellValue("K1", "AMORTIZACIÓN ANUAL ANTERIOR");
        $sheet->setCellValue("L1", "AMORTIZACIÓN ANUAL ACUMULADA ANTERIOR");
        $sheet->setCellValue("M1", "FECHA BAJA DEFINITIVA");
        $sheet->setCellValue("N1", "OBSERVACIONES");
        $sheet->setCellValue("O1", "ACTO ADMINISTRATIVO");

        
        //$sheet->setCellValue("A2", "pepe");
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
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
        $sheet->getColumnDimension('M')->setWidth(25,'px');
        $sheet->getColumnDimension('N')->setWidth(25,'px');
        $sheet->getColumnDimension('O')->setWidth(25,'px');

        


        if($dataProvider->getTotalCount() > 0){
            $fila=1;
            //while ($row = pg_fetch_array($dataProvider)){/
            for($i=0;$i<$dataProvider->getTotalCount();$i++){
                $linea = $dataProvider->getModels()[$i];

                $fila ++;
                //$sheet->setCellValueByColumnAndRow(1, $fila, "hola");
                // $sheet->setCellValue("A".$fila, strval($linea['coddel_actuante']).' - '.$linea['desdele']);
                $sheet->setCellValue("A".$fila, strval($linea['nro_inventario']));
                $sheet->setCellValue("B".$fila, strval($linea['codigo_presupuestario']));
                $sheet->setCellValue("C".$fila, strval($linea['descripcion_bien']));
                $sheet->setCellValue("D".$fila, strval($linea['precio_origen']));
                $sheet->setCellValue("E".$fila, strval($linea['vida_util']));
                $sheet->setCellValue("F".$fila, strval($linea['amortizacion_anual']));
                $sheet->setCellValue("G".$fila, strval($linea['vida_util_transcurrida']));
                $sheet->setCellValue("H".$fila, strval($linea['valor_residual']));
                $sheet->setCellValue("I".$fila, strval($linea['valor_rezago']));
                $sheet->setCellValue("J".$fila, strval($linea['anio_alta']));
                $sheet->setCellValue("K".$fila, strval($linea['amortizacion_anual_acumulada']));
                $sheet->setCellValue("L".$fila, strval($linea['amortizacion_anual_acumulada_anterior']));
                $sheet->setCellValue("M".$fila, strval($linea['fecha_baja_definitiva']));
                $sheet->setCellValue("N".$fila, strval($linea['observaciones']));
                $sheet->setCellValue("O".$fila, strval($linea['acto_admin']));


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
     * Finds the BienUso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BienUso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BienUso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelDetallesContables($id){
        if (($model = BienUsoContables::findOne($id)) !== null) {
            return $model;
        }
    
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelDetallesSeguro($id){
        if (($model = BienUsoSeguro::findOne($id)) !== null) {
            return $model;
        }
    
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelDetallesGarantia($id){
        if (($model = BienUsoGarantia::findOne($id)) !== null) {
            return $model;
        }
    
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
