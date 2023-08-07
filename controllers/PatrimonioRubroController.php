<?php

namespace patrimonio\controllers;
use patrimonio\models\search\PatrimonioRubroSearch;
use Yii;
use patrimonio\parametros\PatrimonioRubro;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PatrimonioRubroController implements the CRUD actions for PatrimonioRubro model.
 */
class PatrimonioRubroController extends Controller
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
     * Lists all PatrimonioRubro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioRubroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioRubro model.
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
     * Creates a new PatrimonioRubro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      
        $model = new PatrimonioRubro();
        $idCab=null;
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $model->setAttribute('fecha_carga',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_carga',Yii::$app->user->identity->id);  
            
           
            $model->save();

            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            // die();
            return $this->redirect(['index', 'id' => $idCab]);
        }
        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);

       
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing PatrimonioRubro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);   
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);
        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }


    /**
     * Deletes an existing PatrimonioRubro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // $this->findModel($id)->delete();
        $model->setAttribute('fecha_baja',date('Y-m-d H:i:s'));
        $model->setAttribute('id_usuario_baja',Yii::$app->user->identity->id);
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the PatrimonioRubro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioRubro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioRubro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
