<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tracking;

/**
 * TrackingSearch represents the model behind the search form of `app\models\Tracking`.
 */
class TrackingSearch extends Tracking
{

    public $pelampung, $koordinator;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_pelampung'], 'integer'],
            [['nama_kejadian', 'tempat_kejadian', 'waktu', 'status', 'pelampung', 'koordinator'], 'safe'],
            [['latitude', 'longitude'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tracking::find();
        $query->joinWith(['pelampung', 'pelampung.koordinator']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'id_pelampung' => $this->id_pelampung,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            //'waktu' => $this->waktu,
        ]);

        $query->andFilterWhere(['like', 'nama_kejadian', $this->nama_kejadian])
            ->andFilterWhere(['like', 'tempat_kejadian', $this->tempat_kejadian])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'waktu', $this->waktu])
            ->andFilterWhere(['like', 'pelampung.nama', $this->pelampung])
            ->andFilterWhere(['like', 'koordinator.nama', $this->koordinator]);
        return $dataProvider;
    }
}
