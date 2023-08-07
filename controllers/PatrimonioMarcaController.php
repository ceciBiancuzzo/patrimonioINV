<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioMarca;
use patrimonio\models\search\PatrimonioMarcaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActaRecepcionCabeceraController implements the CRUD actions for ActaRecepcionCabecera model.
 */
class PatrimonioMarcaController extends Controller
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
        $searchModel = new PatrimonioMarcaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
     * Creates a new PatrimonioMarca model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      
        $modelMarca = new PatrimonioMarca();
        $post= Yii::$app->request->post();
        if ($post != null) {
            $modelMarca->denominacion = $post['denominacion'];
            $modelMarca->setAttribute('fecha_carga',date('Y-m-d H:i:s'));  
            $modelMarca->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);

            $modelMarca->save();
        }

       // return $this->renderAjax('_form', [ 'model' => $modelMarca, 'modo' => '']);
        $marcas = [
            'id'=>$modelMarca->id,
            'denominacion' => $modelMarca->denominacion,
        ];
        return json_encode($marcas);
    }

    public function actionCreateMarca()
    {
       
        $model = new PatrimonioMarca();
        $idCab=null;
        if ($model->load(Yii::$app->request->post())) {
           
            $model->setAttribute('fecha_carga',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);
            $model->save();
            return $this->redirect(['index', 'id' => $idCab]);
        }
        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);

       
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing ActaRecepcionCabecera model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $searchModel = new PatrimonioMarcaSearch();

        if ($model->load(Yii::$app->request->post())  ) {
            $model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);   
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->renderAjax('_form_editar_marca', [ 'model' => $model, 'modo' => '']);
      //  $dataProvider = $searchModel->$model->denominacion;

        // return $this->render('index', [
        //     'dataProvider' => $dataProvider,
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing ActaRecepcionCabecera model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->id_usuario_baja= Yii::$app->user->identity->id;
        $model->fecha_baja=date('Y-m-d H:m:s');
        $model->save();

        return $this->redirect(['index']);
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
        if (($model = PatrimonioMarca::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
