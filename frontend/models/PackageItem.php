<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "package_item".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $price
 */
class PackageItem extends MyModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title','parent_id'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' =>500],
            [['image', 'price'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'image' => Yii::t('app', 'Image'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'parent_id']);
    }
}
