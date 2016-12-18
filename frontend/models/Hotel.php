<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hotel".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $country_id
 * @property integer $city_id
 * @property string $neighborhood
 * @property string $address
 * @property string $image
 * @property string $latlong
 * @property string $sku
 * @property integer $stars
 */
class Hotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'country_id', 'city_id', 'neighborhood', 'address', 'image', 'latlong', 'sku', 'stars'], 'required'],
            [['text'], 'string'],
            [['country_id', 'city_id', 'stars'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['neighborhood'], 'string', 'max' => 100],
            [['address', 'image'], 'string', 'max' => 255],
            [['latlong'], 'string', 'max' => 20],
            [['sku'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'country_id' => Yii::t('app', 'Country ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'neighborhood' => Yii::t('app', 'Neighborhood'),
            'address' => Yii::t('app', 'Address'),
            'image' => Yii::t('app', 'Image'),
            'latlong' => Yii::t('app', 'Latlong'),
            'sku' => Yii::t('app', 'Sku'),
            'stars' => Yii::t('app', 'Stars'),
        ];
    }
}
