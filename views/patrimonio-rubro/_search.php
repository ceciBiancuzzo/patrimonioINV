<!-- 

    ?= $form->field($model, 'codigo_presupuestario') ?>



    <= $form->field($model, 'denominacion') ?>
 -->
 <?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\TabularForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\search\ActaTransferenciaDetSearch */
/* @var $form yii\widgets\ActiveForm */
$marcas= patrimonio\parametros\PatrimonioRubro::find()->where(['fecha_baja' => null]) ->orderBy(['id' => SORT_DESC])->all();
?>

<div class="acta-transferencia-det-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'formprincipal'

    ]); ?>


    <?=
    Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 3,
        'attributes' => [
            
            'denominacion' => ['label' => 'Rubro ', 'type' => Form::INPUT_WIDGET, 
                            'widgetClass' => '\kartik\widgets\Select2',
                            'options' => [
                            'data'=>yii\helpers\ArrayHelper::map($marcas,'denominacion','denominacion'),
                            'options' => ['placeholder' => 'Seleccione el rubro'], 
                            ],
                            
            
                        ],
                        ],      
       
   ]);
   ?>
    

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
