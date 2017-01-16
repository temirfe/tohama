<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $note
 * @property integer $hotel_id
 * @property string $admin_note
 *
 * @property Hotel $hotel
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'name', 'phone', 'email','hotel_id'], 'required'],
            [['hotel_id'], 'integer'],
            [['title', 'name', 'note', 'admin_note'], 'string', 'max' => 500],
            [['phone', 'email'], 'string', 'max' => 100],
            [['date_book'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Full Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'note' => 'Note',
            'hotel_id' => 'Hotel ID',
            'admin_note' => 'Admin Note',
            'date_book' => 'Date booked',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['country_id' => 'hotel_id']);
    }
}
