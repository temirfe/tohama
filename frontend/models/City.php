<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class City extends \yii\db\ActiveRecord
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
        return [
            [['title', 'image'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 200],
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
            'image' => Yii::t('app', 'Image'),
        ];
    }
}
