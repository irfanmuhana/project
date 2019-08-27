<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Koordinator */

$this->title = 'Create Koordinator';
$this->params['breadcrumbs'][] = ['label' => 'Koordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="koordinator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
