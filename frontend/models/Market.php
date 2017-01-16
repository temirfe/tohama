<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "market".
 *
 * @property integer $id
 * @property string $title
 * @property integer $code
 * @property integer $country_id
 *
 * @property Country $country
 * @property Sku[] $skus
 */
class Market extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'market';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code', 'country_id'], 'required'],
            [['code', 'country_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'code' => Yii::t('app', 'Code'),
            'country_id' => Yii::t('app', 'Country ID'),
        ];
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
    public function getSkus()
    {
        return $this->hasMany(Sku::className(), ['market_id' => 'id']);
    }
}
