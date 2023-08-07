<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioEncargadoPatrimonial;
use patrimonio\parametros\PatrimonioDependencia;

use patrimonio\models\search\PatrimonioEncargadoPatrimonialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use patrimonio\models\search\PatrimonioDependenciaSearch;
/**
 * PatrimonioEncargadoPatrimonialController implements the CRUD actions for PatrimonioEncargadoPatrimonial model.
 */
class PatrimonioEncargadoPatrimonialController extends Controller
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
     * Lists all PatrimonioEncargadoPatrimonial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioDependenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioEncargadoPatrimonial model.
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
     * Creates a new PatrimonioEncargadoPatrimonial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
       // $model = new PatrimonioDependencia();
        $model = PatrimonioDependencia::find()->where(['id'=>($id)])->one();
        $post = Yii::$app->request->post();
       
        if ( $post !=null){
            $model->id_encargado = $post['PatrimonioDependencia']['id_encargado'];
            $model->id_encargado2 = $post['PatrimonioDependencia']['id_encargado2'];
            $model->setAttribute('fecha_carga_encargado1',date('Y-m-d H:i:s')); 
            $model->setAttribute('fecha_carga_encargado2',date('Y-m-d H:i:s'));
           
        //         echo "<pre>";
        //     print_r($model);
        //     echo "</pre>";
        //   die();

        $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);

        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);
    }

    /**
     * Updates an existing PatrimonioEncargadoPatrimonial model.
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
     * Deletes an existing PatrimonioEncargadoPatrimonial model.
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
     * Finds the PatrimonioEncargadoPatrimonial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioEncargadoPatrimonial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioEncargadoPatrimonial::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
