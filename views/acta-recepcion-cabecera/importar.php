<?php 
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                'options' => ['accept' => 'file/txt'],
            ])->label("Carga de archivo garantía detalle");?>

<<<<<<< HEAD
<?php ActiveForm::end() ?>
=======
<?php ActiveForm::end() ?>
>>>>>>> aprobacion_bodega-gerFinal
