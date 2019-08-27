<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pelampung".
 *
 * @property int $id
 * @property int $id_koordinator
 * @property string $nama
 *
 * @property Koordinator $koordinator
 * @property Tracking[] $trackings
 */
class Pelampung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelampung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_koordinator', 'nama'], 'required'],
            [['id_koordinator'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['id_koordinator'], 'exist', 'skipOnError' => true, 'targetClass' => Koordinator::className(), 'targetAttribute' => ['id_koordinator' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_koordinator' => 'Id Koordinator',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKoordinator()
    {
        return $this->hasOne(Koordinator::className(), ['id' => 'id_koordinator']);
    }

    public function getKoordinator_id() 
    {
    return $this->koordinator->id;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrackings()
    {
        return $this->hasMany(Tracking::className(), ['id_pelampung' => 'id']);
    }

    public function getTracking()
    {
        return $this->hasOne(Tracking::className(), ['id_pelampung' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PelampungQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PelampungQuery(get_called_class());
    }
}
