<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class City extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules=[
            [['title'], 'required'],
            [['country_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 200],
        ];
        
        return ArrayHelper::merge(parent::rules(),$rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'country_id' => Yii::t('app', 'Country'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
        ];
    }
}
