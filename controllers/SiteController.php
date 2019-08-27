<?php

namespace app\controllers;

use Yii;
use yii\faker;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\widgets\Pjax; 
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Koordinator;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\LatLngBounds;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\overlays\Polyline;
use dosamigos\google\maps\layers\BicyclingLayer;
use CiroVargas\GoogleDistanceMatrix;
use app\models\Tracking;
use app\models\Pelampung;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $enableCsrfValidation = false;
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        if (!Yii::$app->user->isGuest) { 
        return $this->render('index');    
        }
        else {
        return $this->redirect(['site/login']); 
       }

    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
         }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionShowMap()
    {
        // $coord = new LatLng(['lat' => 39.720089311812094, 'lng' => 2.91165944519042]);
        // $map = new Map([
        //     'center' => $coord,
        //     'zoom' => 17,
        //     'width' => '100%',
        //     'height' => '500',
        // ]);
    
        if (empty($_GET)){
            $allPelampung = Pelampung::find()
            ->select('pelampung.*, tracking.*')
            ->leftJoin('tracking', '`tracking`.`id_pelampung` = `pelampung`.`id`')
            ->asArray()
            ->all();
        }
        else {
            $allPelampung = Pelampung::find()
            ->select('pelampung.*, tracking.*')
            ->leftJoin('tracking', '`tracking`.`id_pelampung` = `pelampung`.`id`')
            ->where(['like', 'waktu',$_GET['waktu']])
            ->asArray()->all();

        }
        if (empty($_GET)){
            $allPelampung = Pelampung::find()
            ->select('pelampung.*, tracking.*')
            ->leftJoin('tracking', '`tracking`.`id_pelampung` = `pelampung`.`id`')
            ->asArray()
            ->all();
        }
        else {
            $allPelampung = Pelampung::find()
            ->select('pelampung.*, tracking.*')
            ->leftJoin('tracking', '`tracking`.`id_pelampung` = `pelampung`.`id`')
            ->where(['like', 'id_pelampung',$_GET['id_pelampung']])
            ->asArray()->all();
        }

        // foreach ($allPelampung as $pelampung) {
        //     // echo $pelampung->id;
        //     // echo $pelampung->nama;

        //     $pelampungCoordinate = Tracking::find()->where([
        //         'id_pelampung' => $pelampung->id,
        //     ])->orderBy(['id' => SORT_DESC])->one();
            
        //     // echo $pelampungCoordinate->latitude;
        //     // echo $pelampungCoordinate->longitude;
        //     $coord = new LatLng(['lat' => $pelampungCoordinate->latitude, 'lng' => $pelampungCoordinate->longitude]);
        //     $marker = new Marker([
        //         'position' => $coord,
        //         'title' => $pelampung->nama,
        //     ]);
        //     $marker->attachInfoWindow(
        //         new InfoWindow([
        //             'content' => '<p>'.$pelampung->nama.'</p>'
        //         ])
        //     );

        //     // Add marker to the map
        //     $map->addOverlay($marker);
        // }

        $allKoordinator = Koordinator::find()
            ->asArray()
            ->all();

        //  foreach ($allKoordinator as $koordinator) {
        //     // echo $pelampung->id;

            
        //     // echo $pelampungCoordinate->latitude;
        //     // echo $pelampungCoordinate->longitude;
        //     $coord = new LatLng(['lat' => $koordinator->latitude, 'lng' => $koordinator->longitude]);
        //     $marker = new Marker([
        //         'position' => $coord,
        //         'title' => $koordinator->nama,
        //     ]);
        //     $marker->attachInfoWindow(
        //         new InfoWindow([
        //             'content' => '<p>'.$koordinator->nama.'</p>'
        //         ])
        //     );

        //     // Add marker to the map
        //     $map->addOverlay($marker);
        // }

        return $this->render('showMap', [
            'allPelampung' => $allPelampung,
            'allKoordinator' => $allKoordinator,
        ]);
    }

    public function actionTerimaData($id_pelampung, $latitude, $longitude)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $newTracking = new Tracking();
        $newTracking->id_pelampung = $id_pelampung;
        $newTracking->latitude = $latitude;
        $newTracking->longitude = $longitude;
        $newTracking->save();

        return ['status' => 'Data tersimpan'];
    }

    public function actionChecklocation(){
        $response = [
            'pelampung' => [],
            'koordinator' => []
        ];
        
        $pelampung = Pelampung::find()->all();
        $koordinator = Koordinator::find()->all();

        for ($i=0;$i<count($pelampung);$i++){
            $response['pelampung']['pelampung' . ($i+1)] = [
                'latitude' => $pelampung[$i]->tracking->latitude,
                'longitude' => $pelampung[$i]->tracking->longitude,
                'id_koordinator' => 'koordinator' . $pelampung[$i]->id_koordinator
            ];
        }

        for ($i=0;$i<count($koordinator);$i++){
            $response['koordinator']['koordinator' . ($i+1)] = [
                'latitude' => $koordinator[$i]->latitude,
                'longitude' => $koordinator[$i]->longitude
            ];
        }

        return json_encode($response);
    }
}
