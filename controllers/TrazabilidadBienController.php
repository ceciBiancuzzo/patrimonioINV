<?php

namespace patrimonio\controllers;
use kartik\mpdf\Pdf;
use Yii;
use patrimonio\models\TrazabilidadBien;
use patrimonio\models\search\TrazabilidadBienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrazabilidadBienController implements the CRUD actions for TrazabilidadBien model.
 */
class TrazabilidadBienController extends Controller
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
     * Lists all TrazabilidadBien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \patrimonio\models\search\TrazabilidadBienSearch();
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

    /**
     * Displays a single TrazabilidadBien model.
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
     * Creates a new TrazabilidadBien model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrazabilidadBien();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrazabilidadBien model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TrazabilidadBien model.
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

    /**
     * Finds the TrazabilidadBien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrazabilidadBien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrazabilidadBien::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    //metodo para imprimir
    public function actionPrint(){
       
        $searchModel = new TrazabilidadBienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // print_r(Yii::$app->request->queryParams);
        // die();

        $content = $this->renderPartial('print',['model'=>$dataProvider->models]);
        $pdf = new Pdf([
                        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                        'content' => $content,
                        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                        'cssInline' => '.table td{font-size:11px}', 
                        'format' => Pdf::FORMAT_A4,
                        'orientation' => 'L',
                        'options' =>    [
                                            'title' => "Trazabilidad",
                                        ],
                        
                         ]);

        $response = Yii::$app->response;

        $response->format = \yii\web\Response::FORMAT_RAW;

        $headers = Yii::$app->response->headers;

        $headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    } 
}
