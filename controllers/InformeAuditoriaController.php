<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\InformePatrimonial;
use patrimonio\models\ActaTransferenciaCab;
use patrimonio\models\search\InformeAuditoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use patrimonio\models\BienUso;
use patrimonio\models\search\BienUsoSearch;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\controllers\BienUsoController;
use kartik\mpdf\Pdf;


/**
 * InformePatrimonialController implements the CRUD actions for InformePatrimonial model.
 */
class InformeAuditoriaController extends Controller
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
     * Lists all InformePatrimonial models.
     * @return mixed
     */
    
/**
     * Lists all InformePatrimonial models.
     * @return mixed
     */
    public function actionIndex()
    {   
        set_time_limit(0);

        $searchModel = new InformeAuditoriaSearch();
       
 
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single InformePatrimonial model.
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


    public function actionPrint($area){
        
        
         //$model = $this->findModel($id);
         $model = BienUso::find()
            ->where(['id_dependencia'=>$area])
            ->orderBy(['nro_inventario' => SORT_ASC])
            ->all();
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // ${exit()};

        $content = $this->renderPartial('print',['model'=>$model, 'area'=>$area]);
        $pdf = new Pdf([
                        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                        'content' => $content,
                        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                        'cssInline' => '.table td{font-size:11px}', 
                        'format' => Pdf::FORMAT_A4,
                        'orientation' => 'L',
                        'options' =>    [
                            'title' => 'INFORME PATRIMONIAL',
                                        ],
                        
                         ]);
    
        $response = Yii::$app->response;
    
        $response->format = \yii\web\Response::FORMAT_RAW;
    
        $headers = Yii::$app->response->headers;
    
        $headers->add('Content-Type', 'application/pdf');
        
        return $pdf->render();
        }    
        
    
    /**
     * Updates an existing InformePatrimonial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        set_time_limit(0);

        $model = $this->findModel($id);
        
        $searchModel = new InformeAuditoriaSearch();
    
        $dataProvider = $searchModel->searchArea($model->id);
     
        return $this->render('_form', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }
   
    
    /**
     * Deletes an existing InformePatrimonial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionViewTransferencia($id_acta_transferencia)
    {   
        
        $model= ActaTransferenciaCab::find()
        ->where(['id'=>$id_acta_transferencia])
        ->andWhere(['id_estado_formulario' => 3])
        ->one();
            return $this->renderPartial('view-transferencia',['model'=>$model]);
    }
    public function actionAutorizacionMasiva(){
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['PatrimonioDependencia']['id']);
        if($post != null){
            $model->id_estado_formulario = 6;
            $model->observaciones= $post['PatrimonioDependencia']['observaciones'];
            $model->observaciones_admin= $post['PatrimonioDependencia']['observaciones_admin'];
            $model->id_usuario_presentacion = Yii::$app->user->identity;
            $model->fecha_presentacion = date('Y-m-d H:i:s');

            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La presentación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        return $this->redirect(['index']);
        
        
    }
    public function actionAprobar(){
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['PatrimonioDependencia']['id']);
        $bienes = BienUso::find()->where(['id_dependencia' => $model->id])->all();
        if($model->id_estado_formulario == 6){
            if($post != null){
                $model->id_estado_formulario = 3;
                $model->id_usuario_aprobacion = Yii::$app->user->identity;
                $model->fecha_aprobacion = date('Y-m-d H:i:s');

                foreach($bienes as $bien){
                    $bien->faltante= 0;
                }
           

                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', 'El informe se aprobó con éxito');
                }else{
                    Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
                }
            }
            return $this->redirect(['index']);
        }else{
            Yii::$app->getSession()->setFlash('danger', 'No se pudo aprobar el informe debido a que el mismo no se encuentra presentado');
            return $this->redirect(['index']);

        }
        
        
    }
    public function actionDeclararSobrantes(){
        $model = new BienUso();
        $post = Yii::$app->request->post();
        if($post != null){

        }
        return $this->renderAjax('sobrantes', [ 'model' => $model, 'modo' => '']);


    }
    public function actionDatosBien($nro_inventario){
        $model = new BienUso();
        $post = Yii::$app->request->post();
        $error = '';  
        $datos = [];  
        $cerrado= false;
            if($nro_inventario != null){
                $bien = BienUso::find()->where(['nro_inventario'=>$nro_inventario])->one();
                Yii::trace($bien);
                        if(!empty($bien)){                        
                                $bien_inventario= $bien->nro_inventario;
                                $bien_tipo_bien = $bien->tipo_bien;
                                $bien_marca =  $bien->id_marca;
                                $bien_modelo = $bien->modelo;
                                $bien_dependencia =  $bien-> id_dependencia;

                                $dependencia = PatrimonioDependencia::find()->where(['id'=>$bien_dependencia])->one();

                                $dependencia_denominacion = $dependencia->denominacion;
                                $datos = [
                                    'nro_inventario' =>  $bien_inventario,
                                    'tipo_bien' => $bien_tipo_bien,
                                    'marca' =>  $bien_marca,
                                    'modelo' => $bien_modelo,
                                    'dependencia' => $dependencia_denominacion,
                                ];
                        }else{
                            $error = "NO EXISTE";
                        }
                
            }

           /* print_r($datos);
           die(); */
            return \yii\helpers\Json::encode(['error'=>$error,'datos'=>$datos]);    
    }    


    public function actionFaltantes(){
        
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
            if (!empty($post['ids'])  ) {
               // print_r($post['obs']);
               

                foreach ($post['ids'] as $id) {
                    $model =BienUso::find()
                    ->where(['id' => $id])
                    ->one();
                    Yii::trace("hola");

                    $model->faltante = true;
                        
                    $model->save();

                    $modelDependencia = PatrimonioDependencia::find()
                    ->where(['id' => $model->id_dependencia])
                    ->one(); 
                    Yii::trace($post);
                    
                }
                return $this->redirect(['update', 'id' => $modelDependencia->id]);

            // }else{
            //      Yii::$app->getSession()->setFlash('danger', 'No se rechazo el CEC-04 exitosamente');

            // } else {
                
            //     $modelInforme = InformePatrimonial::find()
            //     ->where(['id_area' => $model->id_dependencia])
            //     ->one(); 
            //     Yii::trace($modelInforme);

            //     //print_r($modelInforme);die();
            //     $modelInforme->id_estado_formulario= 6; 
            //     $modelInforme->observaciones= $post ['obs'];
            //     $modelInforme->observaciones_admin= $post ['obs2'];
            //     $modelInforme->save();
            //     return $this->redirect(['index']);


            // }
        }

    }
    

    /**
     * Finds the InformePatrimonial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InformePatrimonial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioDependencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelBien($id)
    {
        if (($model = BienUso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}