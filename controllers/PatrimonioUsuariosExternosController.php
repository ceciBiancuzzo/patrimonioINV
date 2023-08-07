<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioUsuariosExternos;
use patrimonio\models\search\PatrimonioUsuariosExternosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PatrimonioUsuariosExternosController implements the CRUD actions for PatrimonioUsuariosExternos model.
 */
class PatrimonioUsuariosExternosController extends Controller
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
     * Lists all PatrimonioUsuariosExternos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatrimonioUsuariosExternosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatrimonioUsuariosExternos model.
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
     * Creates a new PatrimonioUsuariosExternos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      
        $model = new PatrimonioUsuariosExternos();
        $idCab=null;
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $model->nombre_usuario = $post['PatrimonioUsuariosExternos']['nombre_usuario'];
            $model->id_dependencia = $post['PatrimonioUsuariosExternos']['id_dependencia'];
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
     * Updates an existing PatrimonioUsuariosExternos model.
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
        return $this->renderAjax('_form_editar_usuarios', [ 'model' => $model, 'modo' => '']);
        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Deletes an existing PatrimonioUsuariosExternos model.
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
     * Finds the PatrimonioUsuariosExternos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioUsuariosExternos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioUsuariosExternos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
