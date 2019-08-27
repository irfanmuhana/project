<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tracking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tracking-form">
 <?php
    if (!Yii::$app->user->isGuest) {
    ?>
    <?php
        if (Yii::$app->user->identity->role=='Admin'){
            ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_kejadian')->textarea(['rows' => 6]); ?>

    <?= $form->field($model, 'tempat_kejadian')->textarea(['rows' => 6]); ?>
    

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

 <?php 
    }
        elseif(Yii::$app->user->identity->role=='Kepala Tim'){
    ?>
    <?php $form = ActiveForm::begin(); ?>
   
    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php }
?>
 <?php } 
 else {
 ?>
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'nama_kejadian')->textarea(['rows' => 6, 'readonly'=>true]) ?>
    
    <?= $form->field($model, 'tempat_kejadian')->textarea(['rows' => 6, 'readonly'=>true ]) ?>

    <?= $form->field($model, 'id_pelampung')->textInput(['readonly'=>true ]) ?>

    <?= $form->field($model, 'latitude')->textInput()(['readonly'=>true ]) ?>

    <?= $form->field($model, 'longitude')->textInput(), (['readonly'=>true ]) ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6, 'readonly'=>true ]) ?>

    <?php ActiveForm::end(); ?>

<?php }
?>
</div>