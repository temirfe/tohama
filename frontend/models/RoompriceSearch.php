<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Roomprice;

/**
 * RoompriceSearch represents the model behind the search form about `frontend\models\Roomprice`.
 */
class RoompriceSearch extends Roomprice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_id', 'country_id', 'city_id', 'market_id', 'sgl_room', 'promotional'], 'integer'],
            [['room', 'room_note', 'season', 'meal_plan', 'date_from', 'date_to', 'dbl_person', 'third_pax', 'adult_hb', 'child_bb', 'child_eb', 'child_hb', 'booking_code'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Roomprice::find();

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
            'hotel_id' => $this->hotel_id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'market_id' => $this->market_id,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'sgl_room' => $this->sgl_room,
            'promotional' => $this->promotional,
        ]);

        $query->andFilterWhere(['like', 'room', $this->room])
            ->andFilterWhere(['like', 'room_note', $this->room_note])
            ->andFilterWhere(['like', 'season', $this->season])
            ->andFilterWhere(['like', 'meal_plan', $this->meal_plan])
            ->andFilterWhere(['like', 'dbl_person', $this->dbl_person])
            ->andFilterWhere(['like', 'third_pax', $this->third_pax])
            ->andFilterWhere(['like', 'adult_hb', $this->adult_hb])
            ->andFilterWhere(['like', 'child_bb', $this->child_bb])
            ->andFilterWhere(['like', 'child_eb', $this->child_eb])
            ->andFilterWhere(['like', 'child_hb', $this->child_hb])
            ->andFilterWhere(['like', 'booking_code', $this->booking_code]);

        return $dataProvider;
    }
}
