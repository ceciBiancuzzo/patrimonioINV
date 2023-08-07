<?php

namespace patrimonio\controllers;

use Yii;
use patrimonio\models\AsignacionDeBienes;
use patrimonio\models\search\AsignacionDeBienesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use patrimonio\models\BienUso;
use patrimonio\models\TrazabilidadBien;
use patrimonio\parametros\PatrimonioDependencia;
use gestion_personal\models\PersonalOrganigrama;
use patrimonio\models\search\BienUsoSearch;

/**
 * AsignacionDeBienesController implements the CRUD actions for AsignacionDeBienes model.
 */
class AsignacionDeBienesController extends Controller
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
    /* public function actionCambioUsuario()
    {
        $post = Yii::$app->request->post();
        $model = $this->findModel($post['AsignacionDeBienes']['id']);
        $idCab = $model->getAttribute('id');
        if($post != null){
            
            //trazabilidad
            //$detalles= $model->detalles;
            $modelTrazabilidad = new TrazabilidadBien();
            $modelTrazabilidad->id_solicitud = $idCab;
            $modelTrazabilidad->str_seccion_actual=$model->str_seccion;
            $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
            $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
            $modelTrazabilidad->id_usuario_actual=$model->id_usuario_bien;
            $modelTrazabilidad->id_bien_uso=$detalles[0]->id_bien_uso;
            $modelTrazabilidad->id_estado_formulario=$model->id_estado;
            $modelTrazabilidad->tipo_movimiento ="Asignacion de Bien";
            //modificacion del bien
            $model->id_usuario_bien=

            $modelTrazabilidad->save();
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'La presentación se realizó con éxito');
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
            }
        }
        $idCab = $model->getAttribute('id');
        return $this->redirect(['index', 'id' => $idCab]);
    } */

    /**
     * Lists all AsignacionDeBienes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \patrimonio\models\search\BienUsoSearch();
        $params = Yii::$app->request->queryParams; 
        
        $user = Yii::$app->user->identity->id_agente;
        $areaTransfiere = PatrimonioDependencia::find()
        ->where(
            ['OR',
                ['=','id_encargado',$user],
                ['=','id_encargado2',$user]
            ])
        ->all();
        // $area=null;
        // if($areaTransfiere != null){
        //     $area = $areaTransfiere->id;
        //     }
        //print_r($area);die();
        $mostrar = false;
        $perfil='';
        $rol = Yii::$app->session->get('perfiles');
        foreach ($rol[17] as $roles){  
            $perfil = $perfil . '-' . $roles;
        } 
      
        if(strpos($perfil, 'Administrador')== 1 || strpos($perfil, 'Agente')== 1 || strpos($perfil, 'Auditor')== 1){
                    $mostrar = true;
        }
        
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider= $searchModel->searchBienAmortizado($areaTransfiere,$mostrar,$params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AsignacionDeBienes model.
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
     * Creates a new AsignacionDeBienes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        
        //$model = new BienUso();
        $model = BienUso::find()->where(['id'=>($id)])->one();
        //Busco el id agente
        $agente = Yii::$app->user->identity->id_agente;
        //Busco las secciones que tiene a cargo
        $secciones = PatrimonioDependencia::find()
        ->where(
            ['OR',
                ['=','id_encargado',$agente],
                ['=','id_encargado2',$agente]
            ])
        ->all();

        //Busco a que id organigrama pertenecen esas secciones
        // print_r($secciones);die();
        $idOrganigrama = [];
        foreach($secciones as $organigrama){
            array_push($idOrganigrama,$organigrama->id_organigrama);
        }
        $idSecciones = [];
        foreach($secciones as $organigrama){
            array_push($idSecciones,$organigrama->id);
        }
        $organigrama= PersonalOrganigrama::find()
        ->where(['IN','id',$idOrganigrama])
        ->all();
        $areas =[];
        foreach($organigrama as $secciones){
            array_push($areas,$secciones->cod_desempenio);
        }


        $post = Yii::$app->request->post();
        //$model = $this->findModel($post['AsignacionDeBienes']['id']);
        //$idCab = $model->getAttribute('id');
        if ($post != null) {
                $model->id_usuario_bien = $post['BienUso']['id_usuario_bien'];
                if (!empty($post['BienUso']['usuario_externo'])) {
                    $model->usuario_externo = $post['BienUso']['usuario_externo'];
                }

            //return $this->redirect(['view', 'id' => $model->id])             
                //trazabilidad
                //$detalles= $model->detalles;
                $modelTrazabilidad = new TrazabilidadBien();
                //$modelTrazabilidad->id_solicitud = $idCab;
                $modelTrazabilidad->id_usuario_carga= Yii::$app->user->identity->id;
                $modelTrazabilidad->fecha_carga=date('Y-m-d H:m:s'); 
                $modelTrazabilidad->id_usuario_actual=$post['BienUso']['id_usuario_bien'];
                $modelTrazabilidad->id_bien_uso=$model->id;
                $modelTrazabilidad->id_estado=$model->id_estado_interno;
                $modelTrazabilidad->tipo_movimiento ="Asignacion de bien a usuario";
                //modificacion del bien
                $model->id_usuario_bien= $post['BienUso']['id_usuario_bien'];
                $model->save();
                $modelTrazabilidad->save();
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', 'La asignación se realizó con éxito');
                }else{
                    Yii::$app->getSession()->setFlash('danger', 'Ocurrio un error');
                }
           // $idCab = $model->getAttribute('id');
            return $this->redirect(['index']);
        }
        return $this->renderAjax('_form', [ 'model' => $model, 'modo' => '','areas'=>$areas,'idSecciones'=>$idSecciones]);
    }
    /**
     * Updates an existing AsignacionDeBienes model.
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
     * Deletes an existing AsignacionDeBienes model.
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
     * Finds the AsignacionDeBienes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AsignacionDeBienes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AsignacionDeBienes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
