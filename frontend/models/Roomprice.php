<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "roomprice".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $market_id
 * @property string $room
 * @property string $room_note
 * @property string $season
 * @property string $meal_plan
 * @property string $date_from
 * @property string $date_to
 * @property integer $sgl_room
 * @property string $dbl_person
 * @property string $third_pax
 * @property string $adult_hb
 * @property string $child_bb
 * @property string $child_eb
 * @property string $child_hb
 * @property integer $promotional
 * @property string $booking_code
 * @property integer $excel_id
 *
 * @property Hotel $hotel
 * @property Country $country
 * @property City $city
 */
class Roomprice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roomprice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'country_id', 'city_id', 'market_id', 'room', 'room_note', 'season', 'meal_plan', 'date_from', 'date_to', 'sgl_room', 'dbl_person', 'third_pax', 'adult_hb', 'child_bb', 'child_eb', 'child_hb', 'booking_code'], 'required'],
            [['hotel_id', 'country_id', 'city_id', 'market_id', 'sgl_room', 'promotional','excel_id'], 'integer'],
            [['date_from', 'date_to'], 'safe'],
            [['room', 'room_note'], 'string', 'max' => 50],
            [['season', 'meal_plan', 'dbl_person', 'third_pax', 'adult_hb', 'child_bb', 'child_eb', 'child_hb'], 'string', 'max' => 20],
            [['booking_code'], 'string', 'max' => 30],
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
            'room' => Yii::t('app', 'Room'),
            'room_note' => Yii::t('app', 'Room Note'),
            'season' => Yii::t('app', 'Season'),
            'meal_plan' => Yii::t('app', 'Meal Plan'),
            'date_from' => Yii::t('app', 'Date From'),
            'date_to' => Yii::t('app', 'Date To'),
            'sgl_room' => Yii::t('app', 'Sgl Room'),
            'dbl_person' => Yii::t('app', 'Dbl Person'),
            'third_pax' => Yii::t('app', 'Third Pax'),
            'adult_hb' => Yii::t('app', 'Adult Hb'),
            'child_bb' => Yii::t('app', 'Child Bb'),
            'child_eb' => Yii::t('app', 'Child Eb'),
            'child_hb' => Yii::t('app', 'Child Hb'),
            'promotional' => Yii::t('app', 'Promotional'),
            'booking_code' => Yii::t('app', 'Booking Code'),
        ];
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
