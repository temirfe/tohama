<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $title
 * @property string $iso
 * @property string $iso3
 * @property integer $phonecode
 * @property string $region
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'iso', 'iso3', 'phonecode', 'region'], 'required'],
            [['phonecode'], 'integer'],
            [['title', 'region'], 'string', 'max' => 100],
            [['iso'], 'string', 'max' => 2],
            [['iso3'], 'string', 'max' => 3],
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
            'iso' => Yii::t('app', 'Iso'),
            'iso3' => Yii::t('app', 'Iso3'),
            'phonecode' => Yii::t('app', 'Phonecode'),
            'region' => Yii::t('app', 'Region'),
        ];
    }
}
