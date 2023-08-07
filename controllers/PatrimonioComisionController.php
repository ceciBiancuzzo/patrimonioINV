<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\PatrimonioComision;
use patrimonio\models\search\PatrimonioComisionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PatrimonioComisionController implements the CRUD actions for PatrimonioComision model.
 */
class PatrimonioComisionController extends Controller
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
     * Lists all PatrimonioComision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioComisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioComision model.
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
     * Creates a new PatrimonioComision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PatrimonioComision();
        $idCab=null;
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            
            $model->setAttribute('fecha_carga',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);  
            $model->save();
            return $this->redirect(['index', 'id' => $idCab]);
        }

        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);
    
    }

    /**
     * Updates an existing PatrimonioComision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $model->activa = $post['PatrimonioComision']['activa'];
            $model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id); 
            //print_r($model);die();
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->renderAjax('_form_editar_comision', [ 'model' => $model, 'modo' => '']);
    }

    /**
     * Deletes an existing PatrimonioComision model.
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
     * Finds the PatrimonioComision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioComision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioComision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
