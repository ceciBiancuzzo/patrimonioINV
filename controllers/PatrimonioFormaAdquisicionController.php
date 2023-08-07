<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioFormaAdquisicion;
use patrimonio\models\search\PatrimonioFormaAdquisicionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PatrimonioFormaAdquisicionController implements the CRUD actions for PatrimonioFormaAdquisicion model.
 */
class PatrimonioFormaAdquisicionController extends Controller
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
     * Lists all PatrimonioFormaAdquisicion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioFormaAdquisicionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioFormaAdquisicion model.
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
     * Creates a new PatrimonioFormaAdquisicion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      
        $model = new PatrimonioFormaAdquisicion();
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
     * Updates an existing PatrimonioFormaAdquisicion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            $model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);   
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->renderAjax('_form_editar_adquisicion', [ 'model' => $model, 'modo' => '']);
        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing PatrimonioFormaAdquisicion model.
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
     * Finds the PatrimonioFormaAdquisicion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioFormaAdquisicion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioFormaAdquisicion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
