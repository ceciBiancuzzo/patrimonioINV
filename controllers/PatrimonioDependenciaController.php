<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\parametros\PatrimonioDependencia;
use patrimonio\models\BienUso;
use patrimonio\models\search\PatrimonioDependenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use patrimonio\models\TrazabilidadBien;
/**
 * PatrimonioDependenciaController implements the CRUD actions for PatrimonioDependencia model.
 */
class PatrimonioDependenciaController extends Controller
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
     * Lists all PatrimonioDependencia models.
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
     * Displays a single PatrimonioDependencia model.
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
     * Creates a new PatrimonioDependencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      
        $model = new PatrimonioDependencia();
        $idCab=null;
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())) {
            $model->fecha_carga = date('Y-m-d H:i:s');
            $model->id_usuario_carga= Yii::$app->user->identity->id;
               
            /* echo "<pre>";
            print_r($model);
            echo "</pre>";
            die(); */
            $model->save();
            
            $modelTrazabilidad = new TrazabilidadBien();

            $modelTrazabilidad->id_area_actual= $model->id;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s');
            
            
            //$modelTrazabilidad->tipo_movimiento ="Asignacion de Jefe de area";

                $modelTrazabilidad->tipo_movimiento ="Creacion de area";

            $modelTrazabilidad->save();
        
            return $this->redirect(['index', 'id' => $idCab]);
            
        }
        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '']);

       
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing PatrimonioDependencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post= Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) ) {
            $model->setAttribute('fecha_modificacion',date('Y-m-d H:i:s'));  
            $model->setAttribute('id_usuario_modificacion',Yii::$app->user->identity->id);   

            if($post['PatrimonioDependencia']['id_jefe'] =! null){
                $modelTrazabilidad = new TrazabilidadBien();
                $modelTrazabilidad->tipo_movimiento ="Asignacion de Jefe de area";
                $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s');

                $modelTrazabilidad->id_area_actual= $model->id;

                $modelTrazabilidad->save();

            }
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->renderAjax('_form_editar_dependencia', [ 'model' => $model, 'modo' => '']);
        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }
    /**
     * Deletes an existing PatrimonioDependencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
    
        $usado = BienUso::find()
        ->where(['id_dependencia' => $id])
        ->all();
        
        if ($id!=null) {
            if(empty($usado)){ 
            $model->id_usuario_baja= Yii::$app->user->identity->id;
            $model->fecha_baja=date('Y-m-d H:m:s');
            $model->save();
            Yii::$app->session->setFlash('success', 'Se eliminó el area exitosamente');
            }else{
                Yii::$app->session->setFlash('error', 'No se pudo eliminar el área debido a que se encuentran bienes asignados a la misma');
            }
        }
        return $this->redirect(['index']);
    }
  

    /**
     * Finds the PatrimonioDependencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrimonioDependencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrimonioDependencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
