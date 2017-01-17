<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $image
 * @property string $link
 * @property integer $type
 * @property string $title
 * @property string $description
 */
class Banner extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules=[
            //[['image',], 'required'],
            [['type'], 'integer'],
            [['image'], 'string', 'max' => 50],
            [['link', 'title', 'description'], 'string', 'max' => 500],
        ];

        return ArrayHelper::merge(parent::rules(),$rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels= [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(),$labels);
    }
}
