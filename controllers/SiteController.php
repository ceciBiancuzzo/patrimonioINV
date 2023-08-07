<?php
namespace patrimonio\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use patrimonio\controllers\BienUsoController;



/**
 * Site controller
 */
class SiteController extends \common\controllers\NucleoSiteController
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {    
         return $this->render('index');
    }

}
