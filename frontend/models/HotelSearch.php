<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Hotel;

/**
 * HotelSearch represents the model behind the search form about `frontend\models\Hotel`.
 */
class HotelSearch extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'city_id', 'stars'], 'integer'],
            [['title', 'text', 'neighborhood', 'address', 'image', 'latlong', 'sku','date_from','date_to'], 'safe'],
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
        $query = Hotel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
            'pagination'=>['pageSize'=>50]
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
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'stars' => $this->stars,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'neighborhood', $this->neighborhood])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'latlong', $this->latlong])
            ->andFilterWhere(['like', 'sku', $this->sku]);

        if($this->date_from && $this->date_to){
            $date_from=date('Y-m-d',strtotime($this->date_from));
            $date_to=date('Y-m-d',strtotime($this->date_to));
            $query->with([
                'prices' => function ($q) use($date_from,$date_to) {
                    $q->andWhere("(date_from<='{$date_from}' AND date_to>='{$date_from}') OR (date_from<='{$date_to}' AND date_to>='{$date_to}')");
                },
            ]);
        }

        return $dataProvider;
    }
}
