<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class Package extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules=[
            [['title'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['image'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 255],
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
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
            'description' => Yii::t('app', 'Short Description'),
        ];
    }
}
