<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioEstadosFormularios;
use patrimonio\models\search\PatrimonioEstadosFormulariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PatrimonioEstadosFormulariosController implements the CRUD actions for PatrimonioEstadosFormularios model.
 */
class PatrimonioEstadosFormulariosController extends Controller
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
     * Lists all PatrimonioEstadosFormularios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioEstadosFormulariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioEstadosFormularios model.
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
     * Creates a new PatrimonioEstadosFormularios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      
        $model = new PatrimonioEstadosFormularios();
        $idCab=null;
        $post = Yii::$app->request->post();
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
     * Updates an existing PatrimonioEstadosFormularios model.
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
        return $this->renderAjax('_form_editar_formularios', [ 'model' => $model, 'modo' => '']);
        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing PatrimonioEstadosFormularios model.
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
     * Finds the PatrimonioEstadosFormularios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioEstadosFormularios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioEstadosFormularios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
