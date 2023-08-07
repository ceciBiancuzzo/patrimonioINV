<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\models\BienUso;
use patrimonio\controllerss\BienUsoController;
use gestion_personal\models\PersonalAgente;
use patrimonio\models\TrazabilidadBien;
use patrimonio\controllers\TrazabilidadBienController;
use patrimonio\models\ActaTransferenciaDet;
use patrimonio\models\search\ActaTransferenciaCabSearch;
use patrimonio\models\search\ActaTransferenciaDetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use chsergey\rest\DataProvider;
use kartik\mpdf\Pdf;
use common\models\user;
use gestion_personal\models\PersonalOrganigrama;
use patrimonio\parametros\PatrimonioDependencia;
use common\models\helpers\AppHelpers;

/**
 * ActaTransferenciaCabController implements the CRUD actions for ActaTransferenciaCab model.
 */
class ActaTransferenciaCabController extends Controller{
    /**
     * {@inheritdoc}
     */
    public function behaviors()  {
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
     * Lists all ActaTransferenciaCab models.
     * @return mixed
     *///{}[17]
    public function actionIndex(){
        $searchModel = new ActaTransferenciaCabSearch();
        $user = Yii::$app->user->identity->id_agente;
        $areaTransfiere = PatrimonioDependencia::find()
        ->where(
            ['OR',
                ['=','id_encargado',$user],
                ['=','id_encargado2',$user],
                ['=','id_jefe',$user]


            ])
        ->all();

        // $area=null;
        // if($areaTransfiere != null){
        //     $area = $areaTransfiere->id;
        //     }
        // $area = $areaTransfiere->id;
        //print_r($areaTransfiere);die();
        $area = '';
       //Esto es tratando de lograr que si hay varias areas que esta encargado las busque todas
       
        $area2 = Yii::$app->user->identity->personalAgente->id_seccion;
        $mostrar = false;
        $perfil='';
        $rol = Yii::$app->session->get('perfiles');
        //print_r($rol);die();
        foreach ($rol[17] as $roles){  
            $perfil = $perfil . '-' . $roles;
        } 
            //    print_r($perfil);die();

        if(strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Auditor')== 1){
                $mostrar = true;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$areaTransfiere,$mostrar,$area2);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
   
    public function actionIndexDetalle() {

        $get = Yii::$app->request->get();
         
        $dataProviderDetalle = new \yii\data\ArrayDataProvider([
            'allModels' => [],
        ]);

        if ($get != null) {
            
            $model = ActaTransferenciaCab::find()  
          ->where(['id' => $get['id_cab']]) ->one();
     

             $query = ActaTransferenciaDet::find()
            ->where(['id_cab' => $get['id_cab']])
            ->andWhere(['fecha_baja' => null]);

            $dataProviderDetalle = new ActiveDataProvider([
                'query' => $query,
                
            ]);
        }

        return $this->render('index_detalle', [
                    'model' => $model, 'dataProviderDetalle' => $dataProviderDetalle
        ]);
    }
   /**
     * Creates a new ActaTransferenciaCab model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 

    public function actionCreate()  {            

     
        $model = new ActaTransferenciaCab();
        $idCab=null;
        $post = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post())){
            $model->id_estado_formulario=1;
            $model->setAttribute('fecha_carga',date('Y-m-d H:m:s'));  
            $model->setAttribute('fecha_transferencia',date('Y-m-d '));  
            $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id); 
            $model->id_usuario_transferencia = Yii::$app->user->identity->id_agente;
          
            $model->tipo_solicitud = $post['ActaTransferenciaCab']['tipo_solicitud'];
           
            $model->save();
         
            $idCab = $model->getAttribute('id');
            return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
            //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_cab
            
                   
                    
        }
       
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateDetalle(){
       

        $model = new ActaTransferenciaDet();
       
        // $modelTransferenciaCab =ActaTransferenciaCab::find()
        // ->where(['id' => $id_cab])
        // -> one();
        
        //$seccion = $modelTransferenciaCab->id_seccion;
        $get = Yii::$app->request->get(); 
       
        $post = Yii::$app->request->post();
       
        if ($model->load( $post = Yii::$app->request->post())) { 
        
            $idDet = null;
            $idCab = null;        
            
            if ($model->id_cab != null) { 
         
             
                    if ($model->id != null) {
                        
                        $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);             
                        $model->setAttribute('fecha_modificacion',date('Y-m-d H:m:s'));      
                        
                        // $model->setScenario(\chsergey\rest\Model::SCENARIO_UPDATE);
                     }else{

                        //print_r($post);die();
                         $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);             
                         $model->setAttribute('fecha_carga',date('Y-m-d H:m:s'));    
                         $model->observaciones = $post['ActaTransferenciaDet']['observaciones'];
                         $modelBien = BienUso::find()->where(['id'=>$model->id_bien_uso])->one();
                         $modelBien->transf_actual = true;
                         $modelBien->save();
                        // $model->setScenario(\chsergey\rest\Model::SCENARIO_CREATE);
                      
                    }                  
                  
                         $model->save();
                         $idCab = $model->getAttribute('id_cab');
                        return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
            }            
                    } else if(isset($get["id"])){          
                         $model = $this->findModelDetalle($get["id"]);
        }        
        
        if($get != null && isset($get['id_cab'])){
            $model->setAttribute('id_cab',$get['id_cab']);
        }        
        $modelTransferenciaCab =ActaTransferenciaCab::find()
        ->where(['id' => $model->id_cab])
        -> one();
        
        $seccion = $modelTransferenciaCab->id_dependencia;
        
        return $this->renderAjax('form_detalle', [ 'model' => $model, 'seccion' => $seccion]);
    }  
    

    public function actionUpdateDetalle($id){

        $model= $this->findModelDetalle($id);
        if ($model->load( $post = Yii::$app->request->post())) { 
            
            $model->id_usuario_modificacion= Yii::$app->user->identity->id;
            $model->fecha_modificacion=date('Y-m-d H:m:s');
            $model->observaciones = $post['ActaTransferenciaDet']['observaciones'];

            $model->save();
            $modelBien = BienUso::find()->where(['id'=>$model->id_bien_uso])->one();
            $modelBien->transf_actual = true;
            $modelBien->save();
            return $this->redirect(['index-detalle', 'id_cab' => $model->id_cab]);
        }else{
            $modelTransferenciaCab =ActaTransferenciaCab::find()
            ->where(['id' => $model->id_cab])
            -> one();
            
            $seccion = $modelTransferenciaCab->id_dependencia;
           return $this->renderAjax('form_detalle', [ 'model' => $model, 'seccion' => $seccion]);
        }
    }
    
   
   


 /**
     * Updates an existing ActaTransferenciaCab model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   

    
    public function actionUpdate($id){
      

        //return $this->redirect(['index-detalle', 'id' => $id]);

         $model = $this->findModel($id);
         $post = Yii::$app->request->post();
         if ($model->load(Yii::$app->request->post())){
             if($model-> nro_acta_transferencia !=null){
            $model->setAttribute('fecha_modificacion',date('Y-m-d '));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);   
             }
            $model->save();
            
            $idCab = $model->getAttribute('id');
            return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
            //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_cab
        }

         
         $get = Yii::$app->request->get();
         $dataProviderDetalle = new \yii\data\ArrayDataProvider([
            'allModels' => [],
        ]);

        if ($get != null && isset($get['id'])) {

            $model = ActaTransferenciaCab::find()
                  ->where(['id' => $get['id']]) ->one();
                  //->innerJoin([
                    //'bienUsoDetallesContables'])
                  

           $query = ActaTransferenciaDet::find()->where(['id_cab' => $get['id']])
           ->andWhere(['fecha_baja' => null]);
            $dataProviderDetalle = new ActiveDataProvider([
                'query' => $query,
            ]);
        }

          return $this->render('index_detalle', [
           'model' => $model, 
           'dataProviderDetalle' => $dataProviderDetalle
          ]);

          

    }

     /**
     * Displays a single ActaTransferenciaCab model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){
        return $this->render('index', [
            'model' => $this->findModel($id),
        ]);


    }

   /**
   
     * Deletes an existing ActaTransferenciaCab model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        
        
        $model = $this->findModel($id);
        $fecha_hora_baja = date('Y-m-d H:i:s'); 
        $flag_detalle =true; 

        if($model->id_estado_formulario == 1){

        $detalles= $model->detalles;
        
        foreach($detalles as $detalle){
            $detalle->fecha_baja = $fecha_hora_baja;
            $detalle->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
            $flag_detalle=$detalle->save();
            $modelBien = BienUso::find()->where(['id'=>$detalle->id_bien_uso])->one();
            $modelBien->transf_actual = false;
            $modelBien->save();
            if(!$flag_detalle){
                break;  
            }
        }
        $model->setAttribute('fecha_baja',date('Y-m-d H:i:s'));
        $model->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);        
        $model->save();
        //$model->delete();
        Yii::$app->getSession()->setFlash('success', 'Se eliminó el acta correctamente');
        return $this->redirect(['index']);        
    }else{
        //print_r("hola");die();
        Yii::$app->getSession()->setFlash('danger', 'No se puede eliminar el acta por ya estar presentada');
        return $this->redirect(['index']);

    }
    }
   
    public function actionDeleteDetalle($id) {
     $model = $this->findModelDetalle($id);
    
    
        if ($id!=null) { 
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $modelBien = BienUso::find()->where(['id'=>$model->id_bien_uso])->one();
            $modelBien->transf_actual = false;
            $modelBien->save();
            $model->save();
       
            return $this->redirect(['index-detalle', 'id_cab' => $model->id_cab]);
        }else{
            return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
        }     
    }





    protected function findModelDetalle($id){
        if (($model = ActaTransferenciaDet::findOne($id)) !== null) {
            return $model;
        }

     throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the ActaTransferenciaCab model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActaTransferenciaCab the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = ActaTransferenciaCab::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrint($id){
      
        $model = $this->findModel($id);
       
        $titulo = "";
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

//     $modelTransferenciaCab= ActaTransferenciaCab::find()
//     ->where(['id' => $model->id_cab])
//     -> one();
//    $nroActa=$modelTransferenciaCab->id;
  
//   //  $modelBienUso = new BienUso();
//    $modelBienUso= BienUso::find()
//    ->where(['id' => $model->id_bien_uso])
//    -> one();
//    $modelBienUso->id_estado_interno=3;
//    $modelBienUso->id_condicion=$model->id_condicion;
//    //$modelBienUso->id_usuario_bien=$modelTransferenciaCab->id_usuario_recepcion;
//    $modelBienUso->id_seccion_bien=$modelTransferenciaCab->id_dependencia2;
  
//    $modelBienUso->id_acta_transferencia= $nroActa;
//    $modelBienUso->save();
    public function actionAprobar(){
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['ActaTransferenciaCab']['id']);
        if($post != null){
            $model->id_estado_formulario = 3;
            $model->id_usuario_recepcion = Yii::$app->user->identity->id_agente;
            $detalles= $model->detalles;
            //print_r($model);die();

            //print_r($detalles);die();
            foreach($detalles as $bienes){
               // print_r($model);die();
            $modelBienUso = BienUso::find()
            ->where(['id'=>$bienes->id_bien_uso])
            ->one();
            $modelBienUso->id_dependencia = $model->id_dependencia2;

            $modelBienUso->id_acta_transferencia = $model->id;
            $modelBienUso->id_condicion=$bienes->id_condicion;
            $modelBienUso->transf_actual = false;
                    if($model->tipo_solicitud==2){
                        $modelBienUso->id_estado_interno= 4; 
            
                        }elseif ($model->tipo_solicitud==3) {
                            $modelBienUso->id_estado_interno=7; 
                        }elseif ($model->tipo_solicitud==4) {
                            $modelBienUso->id_estado_interno=5;
                        }
            $modelBienUso->save();
            $idCab = $model->getAttribute('id');

            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_transferencia = $idCab;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
           // $modelTrazabilidad->id_usuario_anterior=$model->id_usuario_transferencia;
            // $modelTrazabilidad->id_usuario_actual=$model->id_usuario_recepcion;
            $modelTrazabilidad->id_bien_uso=$bienes->id_bien_uso;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;
            $modelTrazabilidad->id_area_actual=$model->id_dependencia2;
            $modelTrazabilidad->id_area_anterior=$model->id_dependencia;
            $modelTrazabilidad->id_condicion=$bienes->id_condicion;
            $modelTrazabilidad->tipo_movimiento="Aprobación transferencia del bien";
            $modelTrazabilidad->save();

            }
            
           
    
          
            $model->save();
            
    
            $model->observaciones_aprobado=$post['ActaTransferenciaCab']['observaciones_aprobado'];
            $model->fecha_recepcion = date('Y-m-d H:i:s');
         
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La aprobación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $this->redirect(['index']);
    }
    
    public function actionRechazar($id){
     
       
       
        $post = Yii::$app->request->post();
      
        $idCab =$id;
    
         $model = $this->findModel($post['ActaTransferenciaCab']['id']);
        if($post != null){
            $cant =0;
            $model->id_estado_formulario = 4;
            $detalles= $model->detalles;
            foreach($detalles as $detalle){
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_transferencia = $idCab;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            $modelTrazabilidad->id_bien_uso=$detalle->id_bien_uso;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;
            $modelTrazabilidad->id_area_actual=$model->id_dependencia2;
            $modelTrazabilidad->id_area_anterior=$model->id_dependencia;
            $modelTrazabilidad->id_condicion=$detalle->id_condicion;
            $modelTrazabilidad->tipo_movimiento="Rechazo transferencia del bien";
            $modelTrazabilidad->save();

            $cant++;
            }
            $model->motivo_rechazo=$post['ActaTransferenciaCab']['motivo_rechazo'];
            foreach($detalles as $bienes){
                // print_r($model);die();
             $modelBienUso = BienUso::find()
             ->where(['id'=>$bienes->id_bien_uso])
             ->one();
  
             $modelBienUso->transf_actual = false;
                  
             $modelBienUso->save();
             }
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'El rechazo se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrió un error');
            }
        }
        $this->redirect(['index']);
    }


    public function actionAutorizacionMasiva(){   
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();         
            if (!empty($post)  ) {
                foreach ($post['ids'] as $id) {
                    $model = ActaTransferenciaCab::findOne($id);
                    
                    echo "<script>con sole.log('Debug Objects: " . $id . "' );</script>";
                  
                     Yii::trace($model);
                if ( $model->id_estado_formulario == 1 ) {
                    $idCab=$id;
                    
                         $model->id_estado_formulario =2;
                         $detalles= $model->detalles;
                          $modelTrazabilidad = new TrazabilidadBien();
                         $modelTrazabilidad->id_transferencia = $idCab;
                         $modelTrazabilidad->id_area_actual=$model->id_dependencia2;
                         $modelTrazabilidad->id_area_anterior=$model->id_dependencia;
                         $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
                         $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                        //  $modelTrazabilidad->id_usuario_anterior=$model->id_usuario_transferencia;
                        //  $modelTrazabilidad->id_usuario_actual=$model->id_usuario_recepcion;
                         $modelTrazabilidad->id_bien_uso=$detalles[0]->id_bien_uso;
                         $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;
                         $modelTrazabilidad->id_condicion=$detalles[0]->id_condicion;
                         $modelTrazabilidad->tipo_movimiento="Inicio transferencia de bien";
                         
                         $modelTrazabilidad->save(); 
                         $model->save();
                        return true;
                    }
                }
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Debe seleccionar al menos un acta');
            }
                        return false;
           
         
      
     }



    public function actionRecepcionar($id) {
         $model = $this->findModel($id);
         $model->id_estado_formulario =5;
         $model->fecha_recepcion=date('Y-m-d H:m:s');
         //$model->setAttribute('id_usuario_baja',null);   
         //$model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));
         $model->setAttribute('id_usuario_destinatario',Yii::$app->user->identity->id);     
         $model->save();
         Yii::$app->getSession()->setFlash('success', 'Se aprobó la recepcion del bien!!');      
         
         
         return $this->redirect(['index']);
    } 




     public function actionDatosUsuario($id){
        
        $error = '';
        $datos = [];
        $cerrado= false;
        if ($id){
            $agente = PatrimonioDependencia::find()->where(['id'=>strtoupper($id)])->one();
          
                if(!empty($agente)){  
                    $area =  explode("_",$agente->ubicacion );   
                                                    
                        $datos = [
                           // 'str_departamento' => $area[1], 
                            'str_seccion' =>  $area[1],
                            'id_dependencia' =>  $agente->id_dependencia,  
                           // 'id_departamento' => $agente->id_departamento,
                                                    
                        ];
                }else{
                    $error = "NO EXISTE";
                }
               
            
        }

        return \yii\helpers\Json::encode(['error'=>$error,'datos'=>$datos]);    
    }

    public function actionPresentar(){
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['ActaTransferenciaCab']['id']);
        $idCab = $model->getAttribute('id');
        $usuario = Yii::$app->user->identity->username; 
        $area = PatrimonioDependencia::find()  //BUSCO EL AREA DESTINATARIA
        ->where(['id'=>$model->id_dependencia2])
        ->one();
        $jefename = '';
        $username='';
        $username2='';
        $mail='reporte@inv.gov.ar';
        $jefe = $area->id_jefe;
        $encargado = $area->id_encargado;
        $encargado2= $area->id_encargado2;
       
        


        if($jefe != null){  //Si el area tiene jefe asignado lo busco
           $userjefe = User::find()
           ->where(['id_agente'=>$jefe])
           ->one();
           if($userjefe != null){
            $jefename = $userjefe->username;  
            }
        }
      
        if($encargado != null){ //Busco si hay encargado 1
        $user = User::find()
        ->where(['id_agente'=>$encargado])
        ->one();
            if($user != null){
                $username = $user->username;
            }
        }
        if($encargado2 != null){ //Busco si hay encargado 2
           
            $user2 = User::find()
            ->where(['id_agente'=>$encargado2])
            ->one();
            if($user2 != null){
                $username2 = $user2->username;
            }
           // $mail = $username."@inv.gov.ar";
        }
        if($username != null){

            $mail = $username."@inv.gov.ar";
        }
        if($username2 != null){
            $mail = $username2."@inv.gov.ar";
        }
        if($username != null && $username2 != null){
            $mail = [$username2."@inv.gov.ar",$username."@inv.gov.ar"];
        }
        if($jefename != null && $username != null){
            $mail = [$jefename."@inv.gov.ar",$username."@inv.gov.ar"];
        }
        if($jefename != null && $username != null && $username2 != null){
            $mail = [$jefename."@inv.gov.ar",$username."@inv.gov.ar",$username2."@inv.gov.ar"];
        }
        
        if($post != null){
            $model->id_estado_formulario = 2;
            $detalles= $model->detalles;
            
            foreach($detalles as $detalle){
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_transferencia = $idCab;
            $modelTrazabilidad->id_area_actual=$model->id_dependencia;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            // $modelTrazabilidad->id_usuario_anterior=$model->id_usuario_transferencia;
            // $modelTrazabilidad->id_usuario_actual=$model->id_usuario_recepcion;
            $modelTrazabilidad->id_bien_uso=$detalle->id_bien_uso;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado_formulario;
            $modelTrazabilidad->id_condicion=$detalle->id_condicion;
            $modelTrazabilidad->tipo_movimiento ="Inicio transferencia del bien";
            $modelTrazabilidad->save();
            }
            $cuerpo = "
            <h1>Notificación de Solicitud de Transferencia</h1><br>
            <p>El Area " .$model->areaTransferencia->denominacion.
                 " a cargo del usuario ". $usuario."
                 ha iniciado la transferencia de uno o mas bienes.
                 Se espera y solicita su consulta en el sistema de patrimonio 
                 y su posterior aprobación o rechazo.
            </p>";

            AppHelpers::enviarEmail('reporte@inv.gov.ar', $mail, 'NOTIFICACION DE SOLICITUD DE TRANSFERENCIA', $cuerpo);
            Yii::$app->getSession()->setFlash('success', 'La solicitud ha sido registrada y enviada a autorizar.');
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La presentación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $idCab = $model->getAttribute('id');
        return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
        
        
    }
 
}