<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\base\BootstrapInterface;
use dosamigos\datepicker\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TrackingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
function getKoordinator($value){
    $rows = (new \yii\db\Query())
    ->select(['nama'])
    ->from('koordinator')
    ->where(['id'=>$value])->one();
return $rows['nama'];
}
?>
<div class="tracking-index">
<?php echo Yii::$app->user->identity->role; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
  <?php
    if (!Yii::$app->user->isGuest) {
    ?>
    <?php
        if (Yii::$app->user->identity->role=='Admin'){
            ?>
        <?= GridView::widget([
            'moduleId' => 'gridviewKrajee', 
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                'nama_kejadian:ntext',   
                'tempat_kejadian:ntext',
                [
                    'label' => 'Pelampung',
                    'attribute' => 'pelampung',
                    'value' => function ($data) {
                        return $data->pelampung->nama;
                    }
                ],
                 [
                    'label' => 'Koordinator',
                    'attribute' => 'koordinator',
                    'value' => function ($data) {
                        return $data->pelampung->koordinator->nama;
                    }
                ],
                'latitude',
                'longitude',
                [
                   'attribute'=>'waktu',
                   'value'=>'waktu',
                   'filter'=>DatePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'waktu',
                        'clientOptions'=>[
                            'autoclose'=> true,
                            'format' => 'yyyy-mm-dd',
                        ]
                        ])
                ],
                'status:ntext',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'pjax'=>true,
        ]); ?>
        <?php
        } 
        elseif(Yii::$app->user->identity->role=='Kepala Tim') {
            ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=>"{summary}\n{items}\n<div align='center'>{pager}</div>",
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'nama_kejadian:ntext',   
                'tempat_kejadian:ntext',
                [
                    'label' => 'ID Pelampung',
                    'attribute' => 'id_pelampung',
                    'value' => function ($data) {
                        return $data->pelampung->nama;
                    }
                ],
                 [
                    'label' => 'ID Koordinator',
                    'attribute' => 'id_pelampung',
                    'value' => function ($data) {
                        return getKoordinator($data->pelampung->id_koordinator);
                    }
                ],
                'latitude',
                'longitude',
                [
                   'attribute'=>'waktu',
                   'value'=>'waktu',
                   'filter'=>DatePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'waktu',
                        'clientOptions'=>[
                            'autoclose'=> true,
                            'format' => 'yyyy-mm-dd',
                        ]
                        ])
                ],
                'status:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php
        } else {

             ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{summary}\n{items}\n<div align='center'>{pager}</div>",
        'filterModel' => $searchModel,
        'columns' => [
            'nama_kejadian:ntext',   
            'tempat_kejadian:ntext',
            
            [
                'label' => 'ID Pelampung',
                'attribute' => 'id_pelampung',
                'value' => function ($data) {
                    return $data->pelampung->nama;
                }
            ],
            [
                'label' => 'ID Koordinator',
                'attribute' => 'id_pelampung',
                'value' => function ($data) {
                    return getKoordinator($data->pelampung->id_koordinator);
                }
            ],

            'latitude',
            'longitude',
            [
                   'attribute'=>'waktu',
                   'value'=>'waktu',
                   'filter'=>DatePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'waktu',
                        'clientOptions'=>[
                            'autoclose'=> true,
                            'format' => 'yyyy-mm-dd',
                        ]
                        ])
                ],
            'status:ntext',
        ],
    ]); ?>
    <?php
    }
    ?>
    
    <?php
    } else {
    ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{summary}\n{items}\n<div align='center'>{pager}</div>",
        'filterModel' => $searchModel,
        'columns' => [
            'nama_kejadian:ntext',   
            'tempat_kejadian:ntext',
            
            [
                'label' => 'ID Pelampung',
                'attribute' => 'id_pelampung',
                'value' => function ($data) {
                    return $data->pelampung->nama;
                }
            ],
            [
                'label' => 'ID Koordinator',
                'attribute' => 'id_pelampung',
                'value' => function ($data) {
                    return getKoordinator($data->pelampung->id_koordinator);
                }
            ],

            'latitude',
            'longitude',
            'waktu',
        ],
    ]); ?>
    <?php
    }
    ?>
    <?php Pjax::end(); ?>
</div>
