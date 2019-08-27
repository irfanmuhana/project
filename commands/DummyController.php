<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Tracking;
use app\models\Pelampung;
use app\models\Koordinator;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DummyController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionDummy()
    {

        $data = [
            [
                'nama_kejadian' => 'KM Bangun Baru Tenggelam',
                'tempat_kejadian' => 'Selat Sunda',
                'id_pelampung' => 1,
                'latitude'=> '39.5888875',
                'longitude'=>'10.5877775',
            ],
            [
                'nama_kejadian' => 'KM Bangun Baru Tenggelam',
                'tempat_kejadian' => 'Selat Sunda',
                'id_pelampung' => 2,
                'latitude' => '40.58484848',
                'longitude' => '8.5662566',
            ],
            [
                'nama_kejadian' => 'KM Pertiwi Tenggelam',
                'tempat_kejadian' => 'Laut Jawa',
                'id_pelampung' => 1,
                'latitude' => '35.58484848',
                'longitude' => '8.5662566',
            ],
            [
                'nama_kejadian' => 'KM Pertiwi Tenggelam',
                'tempat_kejadian' => 'Laut Jawa',
                'id_pelampung' => 2,
                'latitude' => '37.58484848',
                'longitude' => '8.5662566',
            ],
            [
                'nama_kejadian' => 'KM Angkasa',
                'tempat_kejadian' => 'Selat Madura',
                'id_pelampung' => 1,
                'latitude' => '38.58484848',
                'longitude' => '7.5662566',
            ],
            [
                'nama_kejadian' => 'KM Angkasa',
                'tempat_kejadian' => 'Selat Madura',
                'id_pelampung' => 1,
                'latitude' => '39.58484848',
                'longitude' => '7.5662566',
            ],
        ];

        $key = array_rand($data);
        $model = new Tracking;
        $model->nama_kejadian = $data[$key]['nama_kejadian'];
        $model->tempat_kejadian = $data[$key]['tempat_kejadian'];
        $model->id_pelampung = $data[$key]['id_pelampung'];
        $model->latitude = $data[$key]['latitude'];
        $model->longitude = $data[$key]['longitude'];

        if ($model->save()){
            echo "Data berhasil disimpan\n";
        }
        else {
            echo "Data gagal disimpan\n";
            echo current($model->errors)[0] . "\n";
        }

        return ExitCode::OK;
    }

    public function actionDummyLocation(){
        while (true){
            $pelampung = Pelampung::find()->all();
            foreach ($pelampung as $x){
                $newLocation = $this->generateLocation($x->tracking->latitude, $x->tracking->longitude);

                $newTracking = new Tracking();
                $newTracking->id_pelampung = $x->id;
                $newTracking->latitude = $newLocation['latitude'];
                $newTracking->longitude = $newLocation['longitude'];
                $newTracking->save();

                echo "Lokasi baru $x->nama berhasil disimpan\n";
            }

            $koordinator = Koordinator::find()->all();
            foreach ($koordinator as $x){
                $newLocation = $this->generateLocation($x->latitude, $x->longitude);
                $x->latitude = $newLocation['latitude'];
                $x->longitude = $newLocation['longitude'];
                $x->save();
                echo "Lokasi baru $x->nama berhasil disimpan\n";
            }
 
            sleep(10);
        }
    }

    private function generateLocation($latitude, $longitude){
        $longitude = (float) $longitude;
        $latitude = (float) $latitude;
        $radius = rand(1,10); // in miles

        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        //echo 'lng (min/max): ' . $lng_min . '/' . $lng_max . PHP_EOL;
        //echo 'lat (min/max): ' . $lat_min . '/' . $lat_max;
        return [
            'latitude' => (($radius%2) == 0) ? $lat_max : $lat_min,
            'longitude' => (($radius%2) == 0) ? $lng_max : $lng_min
        ];
    }
}
