<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "koordinator".
 *
 * @property int $id
 * @property string $nama
 *
 * @property Pelampung[] $pelampungs
 */
class Koordinator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'koordinator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelampungs()
    {
        return $this->hasMany(Pelampung::className(), ['id_koordinator' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return KoordinatorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KoordinatorQuery(get_called_class());
    }
}
