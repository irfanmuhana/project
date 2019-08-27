<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tracking".
 *
 * @property int $id
 * @property string $nama_kejadian
 * @property string $tempat_kejadian
 * @property int $id_pelampung
 * @property double $latitude
 * @property double $longitude
 * @property string $waktu
 * @property string $status
 *
 * @property Pelampung $pelampung
 */
class Tracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kejadian', 'tempat_kejadian', 'status'], 'string'],
            [['id_pelampung'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['waktu'], 'safe'],
            [['id_pelampung'], 'exist', 'skipOnError' => true, 'targetClass' => Pelampung::className(), 'targetAttribute' => ['id_pelampung' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kejadian' => 'Nama Kejadian',
            'tempat_kejadian' => 'Tempat Kejadian',
            'id_pelampung' => 'Id Pelampung',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'waktu' => 'Waktu',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelampung()
    {
        return $this->hasOne(Pelampung::className(), ['id' => 'id_pelampung']);
    }

    /**
     * {@inheritdoc}
     * @return TrackingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrackingQuery(get_called_class());
    }
}
