<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\ActaRecepcionCabecera;
use patrimonio\models\search\ActaRecepcionCabeceraSearch;
use patrimonio\models\ActaRecepcionDetalle;
use patrimonio\controllers\BienUsoController;
use patrimonio\models\BienUso;
use patrimonio\models\search\ActaRecepcionDetalleSearch;
use patrimonio\models\TrazabilidadBien;
use patrimonio\controllers\TrazabilidadBienController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use patrimonio\parametros\PatrimonioDependencia;
use common\models\FileUpload;
use yii\web\UploadedFile;

/**
 * ActaRecepcionCabeceraController implements the CRUD actions for ActaRecepcionCabecera model.
 */
class ActaRecepcionCabeceraController extends Controller
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
     * Lists all ActaRecepcionCabecera models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActaRecepcionCabeceraSearch();
        $user = Yii::$app->user->identity->id_agente;
        $areaTransfiere = PatrimonioDependencia::find()
        ->where(['id_jefe' => $user])->all();
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$mostrar,$areaTransfiere);


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
            // $idBien = $model->detalles[0]->id_bien_uso;
            // $modelBien =  BienUso::find()->where(['id' => $idBien])->one();
            // $idActaBien = $modelBien ->id_acta_recepcion_definitiva;


            $model = ActaRecepcionCabecera::find()
            ->where(['id' => $get['id_cab']]) ->one();
            $idActa= $model->nro_acta;
            $queryBienes = BienUso::find()->where(['id_acta_recepcion_definitiva' => $idActa])
            ->andWhere(['fecha_baja' => null]);

             $query = ActaRecepcionDetalle::find()
            ->where(['id_cab' => $get['id_cab']])
            ->andWhere(['fecha_baja' => null]);

            
            $dataProviderBienes = new ActiveDataProvider([
                'query' => $queryBienes,
                'pagination' => [
                    'pageSize' =>100,
                    ]
            ]);
            $dataProviderDetalle = new ActiveDataProvider([
                'query' => $query,
                
    
            ]);
        }

        return $this->render('index_detalle', [
                'model' => $model,
                'dataProviderBienes'=>$dataProviderBienes,'dataProviderDetalle' => $dataProviderDetalle,
        ]);
    }

    public function actionCargaSerie($id){
        $model = BienUso::find()
        ->where(['id'=>$id])
        ->one();
     
        $get = Yii::$app->request->get(); 
        $post = Yii::$app->request->post();
        if ($post != null) {
            $model->nro_serie = $post['BienUso']['nro_serie'];
            $model->save();
            $idCab = $model->getAttribute('id_acta_recepcion_definitiva');
            $idActaCab = ActaRecepcionCabecera::find()
            ->where(['nro_acta'=>$idCab])
            ->one();
            $idActa = $idActaCab->id;
            return $this->redirect(['index-detalle', 'id_cab' => $idActa]);

        }

        
        return $this->renderPartial('carga_serie', [ 'model' => $model]);
    }

    /**
     * Displays a single ActaRecepcionCabecera model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ActaRecepcionCabecera model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate()  {
        $model = new ActaRecepcionCabecera();
        $post = Yii::$app->request->post();
       
        $idCab=null;
        if ($model->load(Yii::$app->request->post())){

            $model->id_estado=1;
            $model->fecha_carga= date('Y-m-d H:i:s');
            $model->id_usuario_carga = Yii::$app->user->identity->id;
            $model->id_comision = $post['ActaRecepcionCabecera']['id_comision'];

          
            $model->save();
            $idCab = $model->id;
            return $this->redirect(['index-detalle', 'id_cab' => $model->id]);}
            //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_cab
            return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateDetalle(){
        
        $model = new ActaRecepcionDetalle();
        
        $get = Yii::$app->request->get();
         
        
     
      
       
        if ($model->load( $post = Yii::$app->request->post())) { 
            
            $idDet = null;
            $idCab = null;        
            $post = Yii::$app->request->post();
    
            if ($model->id_cab != null) { 
            //    $model->id = $model->getAttribute('id_cab');
            
            
                    if ($model->id != null) {
                        
                      //  $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);             
                       // $model->setAttribute('fecha_modificacion',date('Y-m-d H:m:s'));      
                        $model->id_usuario_modificacion =Yii::$app->user->identity->id;
                        $model->fecha_modificacion= date('Y-m-d H:m:s');
                        //print_r(F$post);die();
                        // $model->setScenario(\chsergey\rest\Model::SCENARIO_UPDATE);
                    }else{    
                        
                        
                        $model->id_usuario_carga =Yii::$app->user->identity->id;
                        $model->fecha_carga =date('Y-m-d H:m:s');
                        $model->id_area_tecnica = $post['ActaRecepcionDetalle']['id_area_tecnica'];
                        $ultDetalle = ActaRecepcionDetalle::find()
                        ->where(['>=','nro_detalle',0 ])
                        ->orderBy(['nro_detalle'=> SORT_DESC])
                        ->one();
                        $model->nro_detalle = $ultDetalle->nro_detalle +1;
                        // print_r($model);die();

                        $modelCab = ActaRecepcionCabecera::find()
                            ->where(['id'=>$model->id_cab])
                            ->one();
                                
                            //ESTE PRIMERO NO HABRIA QUE TOCARLO, PARA QUE PUEDA USARSE DESPUES
                        // $modelBienUso = new BienUso();
                        //print_r($modelDetalle);die();

                        $modelBienUso= BienUso::find()
                            ->where(['id' => $model->id_bien_uso])
                            -> one();
                        
              
                       
                
                
                        for ($i=1; $i<= $model->cantidad ; $i++) { 
                            $modelBien = new BienUso();
                            
                    
                            $modelBien->id_marca = $modelBienUso->id_marca;
                            $modelBien->id_rubro = $modelBienUso->id_rubro;
                            $modelBien->modelo = $modelBienUso->modelo;
                            $modelBien->vida_util = $modelBienUso->vida_util;
                            $modelBien->amortizable = $modelBienUso->amortizable;
                            $modelBien->anio_alta = $modelBienUso->anio_alta;
                            $modelBien->precio_origen = $modelBienUso->precio_origen;
                            $modelBien->id_rubro = $modelBienUso->id_rubro;
                            $modelBien->tipo_bien = $modelBienUso->tipo_bien;
                            $modelBien->id_condicion = $modelBienUso->id_condicion;
                            $modelBien->id_dependencia = $modelBienUso->id_dependencia;
                            $modelBien->id_usuario_bien = $modelBienUso->id_usuario_bien;
                            $modelBien->descripcion_bien = $modelBienUso->descripcion_bien;
                            $modelBien->cantidad = $modelBienUso->cantidad;
                            $modelBien->tipo_identificacion=$modelBienUso->tipo_identificacion;
                            $modelBien->faltante=$modelBienUso->faltante;
                            $modelBien->fecha_carga = date('Y-m-d H:m:s');

                            if($model->necesidad_aprobacion == false){

                                $modelBien->necesidad_aprobacion = false;
                                $modelBien->aprobacion = 2;


                            }
                            if($model->necesidad_aprobacion==true){
                                $modelBien->necesidad_aprobacion = true;
                                $modelBien->aprobacion = 0;

                            }
                            //print_r($modelBien->necesidad_aprobacion);die();
                            $modelBien->id_estado_interno=1; 
                            $modelBien->id_acta_recepcion_definitiva = $modelCab->nro_acta;     
                            $modelBien->id_detalle_acta = $model->nro_detalle;
                            // echo "<pre>";
                            // print_r($modelBien);
                            // echo "</pre>";
                            // die();
                            $modelBien->save();

                            $modelTrazabilidad = new TrazabilidadBien();
                            $modelTrazabilidad->id_bien_uso=$modelBien->id;
                            $modelTrazabilidad->id_estado=$modelBienUso->id_estado_interno;
                            // $modelTrazabilidad->id_condicion->$model->id_condicion;
                            $modelTrazabilidad->id_recepcion=$modelCab->nro_acta;
                            
                            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;      
                            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                            $modelTrazabilidad->tipo_movimiento ="Ingreso provisorio";
                            $modelTrazabilidad->save();
                        }
                         
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
        
        return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
    }
    

    public function actionPresentar(){
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['ActaRecepcionCabecera']['id']);
        $idCab = Yii::$app->request->get('id');
        if($post != null){
            $detalles= $model->detalles;
            $model->id_estado =2;
            $detalles= $model-> detalles;
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_recepcion = $idCab;
            $modelTrazabilidad->id_area_actual=$model->id_dependencia;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            //$modelTrazabilidad->id_usuario_actual=$model->id_usuario_carga;
            if($model->detalles != null){
            $modelTrazabilidad->id_bien_uso=$detalles[0]->id_bien_uso;
            $modelTrazabilidad->id_condicion=$detalles[0]->id_condicion;
            }
            $modelTrazabilidad->id_estado_formulario=$model->id_estado;
            $modelTrazabilidad->tipo_movimiento ="Acta de Recepcion";
            $modelTrazabilidad->id_estado=1;
            $modelTrazabilidad->save();
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La presentación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $idCab = $model->getAttribute('id');
        return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
        
        
    }

   
    public function actionAprobar($id){
        $post = Yii::$app->request->post();
        $model = $this->findModel($id);
        $idCab = Yii::$app->request->get('id');
        $cantidadFinal = 0;
        $bienesActa = BienUso::find()
            ->where(['id_acta_recepcion_definitiva'=>$model->nro_acta])
            ->andWhere(['fecha_baja'=>null])
            ->all();
        if(!empty($bienesActa)){
           
            foreach($bienesActa as $bienes){
                if($bienes->necesidad_aprobacion == true && $bienes->aprobacion == 0){
                    Yii::$app->getSession()->setFlash('danger', 'El acta no se pudo aprobar, hay bienes que requieren aprobación y no han sido aprobados/rechazados');
            
                    return $this->redirect(['index-detalle', 'id_cab' => $model->id]);
                    break;
                }else{
                    
                    continue;

                }
            }
                $modelDetalle = ActaRecepcionDetalle::find()
                    ->where(['id_cab'=>$model->id])
                    ->one();
                //Seteo el estado de la cabecera en 3 (Aprobado)
                $model->id_estado = 3;
                //Busco el bien de uso que esta en ese detalle
                $modelBienUso= BienUso::find()
                ->where(['id' => $modelDetalle->id_bien_uso])
                -> one();
                
                // $modelTrazabilidad = new TrazabilidadBien();
                // $modelTrazabilidad->id_bien_uso=$modelBienUso->id;
                // $modelTrazabilidad->id_estado=$modelBienUso->id_estado_interno;
                // $modelTrazabilidad->id_condicion=$modelDetalle->id_condicion;
                // $modelTrazabilidad->id_recepcion=$model->nro_acta;
                // $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;      
                // $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                // $modelTrazabilidad->tipo_movimiento ="Alta del bien por aprobación de recepcion";
                // $modelTrazabilidad->save();
                
                //Busco a traves de los detalles la cantidad que hay en total
                foreach($model->detalles as $detalles){
                    $cantidadFinal = $detalles->cantidad + $cantidadFinal;
                }
                $cantidadFinal = count($bienesActa);

                //print_r($model->detalles[3]);die();
                    
                //Armo el for que empieza en 1 y sigue hasta la cantidad final
                    for ($i=1; $i<= $cantidadFinal ; $i++) { 

                        //En caso de ser el primero vamos a buscar el bien de uso que tiene este acta de recepcion
                        if($i == 1){
                        $modelBien = BienUso::find()
                        ->where(['id_acta_recepcion_definitiva' => $model->nro_acta])
                        ->andWhere(['fecha_baja' => null])
                        ->one();

                        }
                    //Busco el ultimo numero de inventario para guardar los datos
                        $nroInventario = BienUso::find()
                        ->where(['>=','nro_inventario',0 ])
                        ->orderBy(['nro_inventario'=> SORT_DESC])
                        ->one();
                        //print_r($nroInventario);
                        //print_r($modelBien);die();
                       
                        if($modelBien->aprobacion === 1){
                            $modelBien->id_estado_interno = 18;
                            $modelBien->nro_inventario = 0;  


                        }
                        // $modelBien->id_marca = $modelBien->id_marca;
                        // $modelBien->id_rubro = $modelBien->id_rubro;
                        // $modelBien->modelo = $modelBien->modelo;
                        // $modelBien->nro_serie = $modelBien->nro_serie;
                        // $modelBien->tipo_bien = $modelBien->tipo_bien;
                        // $modelBien->id_partida = $modelBien->id_partida;
                        // $modelBien->id_condicion = $modelBien->id_condicion;
                        // $modelBien->id_dependencia = $modelBien->id_dependencia;
                        // $modelBien->id_usuario_bien = $modelBien->id_usuario_bien;
                        // $modelBien->descripcion_bien = $modelBien->descripcion_bien;
                        //$modelBien->cantidad = $modelBienUso->cantidad;
                        //ESTO ES PARA APROBADOS O NO NECESITA APROBACION
                        //LE DAMOS ESTADO EN STOCK Y NRO DE INVENTARIO
                        if($modelBien->aprobacion == 2 || $modelBien->necesidad_aprobacion == false){
                            $modelBien->id_estado_interno = 2;
                            $modelBien->nro_inventario = $nroInventario->nro_inventario +1;


                        }
                        //$modelBien->id_acta_recepcion_definitiva = $model->nro_acta;     

                        $modelBien->save();
                        $modelTrazabilidad = new TrazabilidadBien();
                        $modelTrazabilidad->id_bien_uso=$modelBien->id;
                        $modelTrazabilidad->id_estado=$modelBien->id_estado_interno;
                        $modelTrazabilidad->id_condicion=$modelDetalle->id_condicion;
                        $modelTrazabilidad->id_recepcion=$model->nro_acta;
                        $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;      
                        $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                        $modelTrazabilidad->tipo_movimiento ="Carga de bien por aprobación de recepcion";
                        $modelTrazabilidad->save();

                        //Para el resto de los casos lo que busco es buscar en los que no tengan inventario para que no se repitan los detalles que ya se 
                        //les asigno numero de inventario
                        $modelBien = BienUso::find()
                        ->where(['id_acta_recepcion_definitiva' => $model->nro_acta])
                        ->andWhere(['nro_inventario' => null])
                        ->andWhere(['fecha_baja' => null])
                        ->one();

                        if($model->save()){
                            Yii::$app->getSession()->setFlash('success', 'La aprobación se realizó con éxito');
                        }else{
                            Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
                        }

                    }
          
           // $model->fecha_aprob = date('Y-m-d H:i:s');
           
        }
        $this->redirect(['index']);
    }

    //El metodo hace que el modelo del acta de recepcion cabecera quede en estado rechazado, y que los bienes que se 
    //han creado de los detalles se setee su estado interno en RECHAZADO PROVISORIO
    public function actionRechazar($id){
        $post = Yii::$app->request->post();
        $idCab = Yii::$app->request->get('id');
        $model = $this->findModel($post['ActaRecepcionCabecera']['id']);
        if($post != null){
            $model->id_estado = 4;
            $detalles= $model->detalles;
           
            $bienes = BienUso::find()
            ->where(['id_acta_recepcion_definitiva' => $model->nro_acta])
            ->all();
            if(!empty($bienes)){
                foreach($bienes as $bien){
                    $bien->id_estado_interno = 18;
                    $bien->save();
                }
            }
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_recepcion = $idCab;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            $modelTrazabilidad->id_usuario_actual=$model->id_usuario_carga;
            //$modelTrazabilidad->id_bien_uso=$detalles[0]->id_bien_uso;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado;
                // if ($model->tipo_solicitud == 2 ) {
                //     $modelTrazabilidad->tipo_movimiento ="Solicitud de Reparacion";
                // }else {
                //     $modelTrazabilidad->tipo_movimiento ="Solicitud de Baja";
                // }
            $modelTrazabilidad->tipo_movimiento ="Acta de Recepcion";
            $modelTrazabilidad->save();
            // $model->motivo_rechazo=$post['ActaRecepcionCabecera ']['motivo_rechazo'];
            $model->id_usuario_modificacion= Yii::$app->user->identity->id;
            //$model->fecha_baja=date('Y-m-d H:m:s');
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'El rechazo se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $this->redirect(['index']);
    }

    //El metodo hace que el bien en especifico se encuentre su aprobacion en rechazado asi, cuando se apruebe el acta
    //va a quedar en rechazado provisorio

    public function actionRechazarRevision($id){

        $post = Yii::$app->request->post();
        $idCab = Yii::$app->request->get('id_cab');
        $model = BienUso::find()
        ->where(['id' => $id])
        ->one();
        $detalleActa = ActaRecepcionDetalle::find()
        ->where(['nro_detalle'=>$model->id_detalle_acta])
        ->one();
        if($post != null){

            $model->tecnico_revision1 = $post['BienUso']['tecnico_revision1'];
            $model->tecnico_revision2 = $post['BienUso']['tecnico_revision2'];
            $model->comentario_revision = $post['BienUso']['comentario_revision'];
            $model->aprobacion = 1;

            $detalleActa->cantidad = $detalleActa->cantidad -1;

            $detalleActa->save();
            //$model->fecha_baja=date('Y-m-d H:m:s');
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'El rechazo se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }

        $idCab = $model->getAttribute('id_acta_recepcion_definitiva');
        $idActaCab = ActaRecepcionCabecera::find()
        ->where(['nro_acta'=>$idCab])
        ->one();
    
        

        return $this->redirect(['index-detalle', 'id_cab' => $idActaCab->id]);
    }
    //El metodo hace que el modelo del acta de recepcion cabecera quede en estado aprobado, y que los bienes que se 
    //han creado de los detalles se setee su estado interno en RECHAZADO PROVISORIO si se rechazo su revisión
    // o en stock si se aprobo la revision
    public function actionAprobarRevision($id){

        $post = Yii::$app->request->post();
        $idCab = Yii::$app->request->get('id_cab');
        $model = BienUso::find()
        ->where(['id' => $id])
        ->one();
        if($post != null){
            $model->tecnico_revision1 = $post['BienUso']['tecnico_revision1'];
            $model->tecnico_revision2 = $post['BienUso']['tecnico_revision2'];
            $model->comentario_revision = $post['BienUso']['comentario_revision'];
            $model->aprobacion = 2;
            //$model->fecha_baja=date('Y-m-d H:m:s');
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La aprobación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $idCab = $model->getAttribute('id_acta_recepcion_definitiva');
        $idActaCab = ActaRecepcionCabecera::find()
        ->where(['nro_acta'=>$idCab])
        ->one();
        $idActa = $idActaCab->id;
        return $this->redirect(['index-detalle', 'id_cab' => $idActa]);
    }

    public function actionUploadFile($id){
        //print_r($id);die();
        set_time_limit(0);
        $model = new FileUpload();        
        $modelDetalle = $this->findModelDetalle($id);
      //  print_r($modelDetalle);die();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
            
            if (!is_null($file)) {
                $name = $file->name;
                
                $explode  = explode(".", $name);
                $ext = end($explode);
                $serverName = $name.''.$id.".{$ext}";
                //$path = Yii::getAlias('@uploads/@patrimonio').$name.$serverName;
               $path = dirname(__DIR__) . "/web/garantias/$serverName";
                $file->saveAs($path);
               // print_r($path);die();
                //print_r($fileContent);die();
               // $model = CosechaCiu::defaultAction('import',['contentFile'=>\utf8_encode($fileContent),'id_usuario'=>$_SESSION['id_persona'],'id_nroins'=>$_SESSION['id_nroins']]);

                if(!empty($modelDetalle)){

                    $modelDetalle->archivo = $serverName;
                    $modelDetalle->save();
                    Yii::$app->getSession()->setFlash('success', "ImportaciÃ³n Realizada con Ã©xito");

                }
                Yii::$app->getSession()->setFlash('success', "ImportaciÃ³n Realizada con Ã©xito");
                $cabecera = $this->findModel($modelDetalle->id_cab);
            }
            return $this->redirect(['index-detalle', 'id_cab' => $modelDetalle->id_cab]);

        }

        return $this->renderAjax('importar',['model'=>$model]);
    }
    public function actionViewFile($id){
       // print_r("hola");die();
        $modelDetalle =  $this->findModelDetalle($id);
        $archivo = $modelDetalle->archivo;
        $url = '@web/garantias/'.$archivo;
        //return $this->renderPartial('printgarantia',['url'=>$url]);
        //return $this->redirect(['printgarantia', 'id_cab' => $modelDetalle->id_cab]);

        return Yii::$app->response->redirect(Url::to([$url]));

    }
     
    public function actionAutorizacionMasiva(){
        $idCab = Yii::$app->request->get('id');
        
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get(); 
        //die();
            if (!empty($post)  ) {
                foreach ($post['ids'] as $id) {
                    $model = ActaRecepcionCabecera::findOne($id);
                    // Yii::trace($model);
                if ( $model->id_estado == 1 ) {
                    // Yii::trace("hola");
                         $detalles= $model->detalles;
                         $model->id_estado =3;
                         $detalles= $model->detalles;
                         $modelTrazabilidad = new TrazabilidadBien();
                         $modelTrazabilidad->id_recepcion = $idCab;
                         $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
                         $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                         $modelTrazabilidad->id_usuario_actual=$model->id_usuario_carga;
                         $modelTrazabilidad->id_bien_uso=$detalles[0]->id_bien_uso;
                         $modelTrazabilidad->id_estado_formulario=$model->id_estado;
                         $modelTrazabilidad->tipo_movimiento ="Presentación acta de recepcion";
                         //print_r($modelTrazabilidad);die();
                         $modelTrazabilidad->save();
                         $model->save();
                        return true;
                    }
                }
            }
           return false;
     }
     public function actionAprobacionTecnica($id){
     
            $model = BienUso::find()
            ->where(['id' => $id])
            ->one();
           if ($model->load( $post = Yii::$app->request->post())){
                    $model->save();
                   
               // $idCab = $model->getAttribute('id');
               return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
            }
            return $this->renderAjax('aprobacion_tecnica', [ 'model' => $model, 'modo' => '']);
     }
    /**
     * Updates an existing ActaRecepcionCabecera model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $post= Yii::$app->request->post();
        if ($post != null){
            if($model->id_estado != 3){
                $model->observacion_acta = $post['ActaRecepcionCabecera']['observacion_acta'];
            }

           $model->nro_gde = $post['ActaRecepcionCabecera']['nro_gde'];
        
            $model->save();
           
           $idCab = $model->getAttribute('id');
           return $this->redirect(['index-detalle', 'id_cab' => $idCab]);
           //CON ESTO LOGRO QUE VAYA A LA URL INDEX-DETALLE id_cab
       }

        
       $get = Yii::$app->request->get();

        $dataProviderDetalle = new \yii\data\ArrayDataProvider([
            'allModels' => [],
        ]);

        if ($get != null) {
            // $idBien = $model->detalles[0]->id_bien_uso;
            // $modelBien =  BienUso::find()->where(['id' => $idBien])->one();
            // $idActaBien = $modelBien ->id_acta_recepcion_definitiva;
            // print_r($idActaBien);die();
            // print_r($model);die();
            $idActa= $model->nro_acta;
            $queryBienes = BienUso::find()->where(['id_acta_recepcion_definitiva' => $idActa])
            ->andWhere(['fecha_baja' => null]);

            $model = ActaRecepcionCabecera::find()
          ->where(['id' => $get['id']]) ->one();


             $query = ActaRecepcionDetalle::find()
            ->where(['id_cab' => $get['id']])
            ->andWhere(['fecha_baja' => null]);

            $dataProviderDetalle = new ActiveDataProvider([
                'query' => $query,

            ]);
            $dataProviderBienes = new ActiveDataProvider([
                'query' => $queryBienes,

            ]);
        }

        return $this->render('index_detalle', [
                'model' => $model,
                'dataProviderDetalle' => $dataProviderDetalle,'dataProviderBienes'=>$dataProviderBienes,
        ]);
   }

   public function actionUpdateDetalle($id){

    $model= $this->findModelDetalle($id);
    if ($model->load( $post = Yii::$app->request->post())) { 
        $model->id_usuario_modificacion= Yii::$app->user->identity->id;
        $model->fecha_modificacion=date('Y-m-d H:m:s');
        $model->save();
        return $this->redirect(['index-detalle', 'id_cab' => $model->id_cab]);
    }else{
       return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
    }
}


    //Esto elimina la cabecera, los detalles y los bienes que se han creado de esos detalles
    //se les da fecha de baja entonces no van a seguir apareciendo. Solo se puede hacer mientras
    //este en borrador
    /**
     * Deletes an existing ActaRecepcionCabecera model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
        $model = $this->findModel($id);
        $fecha_hora_baja = date('Y-m-d H:i:s');
        $flag_detalle = true;
        if($model->id_estado == 1){
        $detalles= $model->detalles;

        foreach($detalles as $detalle){
            $detalle->fecha_baja = $fecha_hora_baja;
            $detalle->id_usuario_baja = Yii::$app->user->identity->id;
            $flag_detalle=$detalle->save();
            // if(!$flag_detalle){
            //     break;
            // }
            $bienes = BienUso::find()
            ->where(['id_detalle_acta' => $detalle->nro_detalle])
            ->all();
            if(!empty($bienes)){
                foreach($bienes as $bien){
                    $bien->id_usuario_baja= Yii::$app->user->identity->id;
                    $bien->fecha_baja = date('Y-m-d H:i:s');
                    $bien->save();
                }
            }
        }
        $model->fecha_baja = $fecha_hora_baja;
        $model->id_usuario_baja = Yii::$app->user->identity->id;
    
        $model->save();
        Yii::$app->getSession()->setFlash('success', 'Se elimino el acta correctamente');
        return $this->redirect(['index']);
        }else{
            //print_r("hola");die();
            Yii::$app->getSession()->setFlash('danger', 'No se puede eliminar el acta por ya estar presentada');
            return $this->redirect(['index']);

        }

    }
    //Esto elimina la los detalles y los bienes que se han creado de esos detalles
    //se les da fecha de baja entonces no van a seguir apareciendo. Solo se puede hacer mientras
    //este en borrador
    public function actionDeleteDetalle($id) {
        
        $model = $this->findModelDetalle($id);
        
        $bienes = BienUso::find()
        ->where(['id_detalle_acta' => $model->nro_detalle])
        ->all();
       
        if($id!=null){
        //if ($model->load( $post = Yii::$app->request->post())) { 
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $model->save();
            if(!empty($bienes)){
                foreach($bienes as $bien){
                    $bien->id_usuario_baja= Yii::$app->user->identity->id;
                    $bien->fecha_baja = date('Y-m-d H:i:s');
                    $bien->save();
                }
            }
            return $this->redirect(['index-detalle', 'id_cab' => $model->id_cab]);
        }else{
           return $this->renderAjax('form_detalle', [ 'model' => $model, 'modo' => '']);
        }     
    }
 

    protected function findModelDetalle($id){
    if (($model = ActaRecepcionDetalle::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}
    /**
     * Finds the ActaRecepcionCabecera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActaRecepcionCabecera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActaRecepcionCabecera::findOne($id)) !== null) {
            return $model;
        }

		throw new NotFoundHttpException('The requested page does not exist.');
    }
    
public function actionPrint($id){
      
    $model = $this->findModel($id);
    $query = ActaRecepcionCabecera::find($id)
    ->where(['fecha_baja' => null]);
    $titulo = "Evaluacion";
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
}