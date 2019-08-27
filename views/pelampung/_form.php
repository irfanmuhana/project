<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pelampung */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelampung-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_koordinator')->textInput() ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
