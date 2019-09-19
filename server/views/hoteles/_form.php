<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Hoteles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hoteles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ciudad_id')->textInput() ?>

    <?= $form->field($model, 'numero_habitaciones')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
