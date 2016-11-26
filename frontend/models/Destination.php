<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "destination".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $price
 * @property string $place
 */
class Destination extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['title'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['image', 'price', 'place'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
            'price' => Yii::t('app', 'Price (optional)'),
            'place' => Yii::t('app', 'Place (optional)'),
        ];
    }
}
