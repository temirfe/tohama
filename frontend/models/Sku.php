<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sku".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $market_id
 * @property string $title
 * @property integer $stars
 * @property string $location
 *
 * @property Market $market
 * @property Hotel $hotel
 * @property Country $country
 * @property City $city
 */
class Sku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'country_id', 'city_id', 'market_id', 'title', 'location'], 'required'],
            [['hotel_id', 'country_id', 'city_id', 'market_id', 'stars'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['location'], 'string', 'max' => 30],
            [['market_id'], 'exist', 'skipOnError' => true, 'targetClass' => Market::className(), 'targetAttribute' => ['market_id' => 'id']],
            [['hotel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hotel::className(), 'targetAttribute' => ['hotel_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hotel_id' => Yii::t('app', 'Hotel ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'market_id' => Yii::t('app', 'Market ID'),
            'title' => Yii::t('app', 'Title'),
            'stars' => Yii::t('app', 'Stars'),
            'location' => Yii::t('app', 'Location'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarket()
    {
        return $this->hasOne(Market::className(), ['id' => 'market_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
