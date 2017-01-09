<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
 * @property string $location
 * @property string $website
 * @property string $phone
 * @property string $thumb
 * @property string $thumbs_sprite
 * @property string $imglinks
 * @property array $skuitem
 * @property integer $stars
 */
class Hotel extends MyModel
{
    public $skuitem=[];
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
        $rules= [
            [['title'], 'required'],
            [['country_id', 'city_id'], 'required', 'except'=>'parse'],
            [['text'], 'string'],
            [['country_id', 'city_id', 'stars'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['neighborhood'], 'string', 'max' => 100],
            [['address', 'image'], 'string', 'max' => 255],
            [['latlong'], 'string', 'max' => 200],
            [['sku'], 'string', 'max' => 1000],
            [['skuitem','location','website','phone','thumb','thumbs_sprite','imglinks'], 'safe'],
        ];

        return ArrayHelper::merge(parent::rules(),$rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels=  [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'neighborhood' => Yii::t('app', 'Neighborhood'),
            'address' => Yii::t('app', 'Address'),
            'image' => Yii::t('app', 'Image'),
            'latlong' => Yii::t('app', 'Latlong'),
            'sku' => Yii::t('app', 'Sku'),
            'stars' => Yii::t('app', 'Stars'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(),$labels);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($this->skuitem){
                $this->sku=implode(';;',$this->skuitem);
            }
            if($this->scenario=='parse' && $this->latlong){
                $this->setLocations($this->latlong,$this->address);
            }

            $this->text=preg_replace("/<a.*?>.*?<\/a>/i",'', $this->text);
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $dao=Yii::$app->db;
        $dao->createCommand()->delete('sku', "hotel_id = {$this->id}")->execute();
        if($this->skuitem){
            foreach($this->skuitem as $sku){
                $dao->createCommand()->insert('sku', [
                    'title' => $sku,
                    'hotel_id' => $this->id,
                    'country_id'=>$this->country_id,
                    'city_id'=>$this->city_id,
                    'stars'=>$this->stars,
                    'location'=>$this->location,

                ])->execute();
            }
        }
    }

    public function setLocations($latlong, $address=''){
        $dao=Yii::$app->db;
        $countries_query = $dao->createCommand("SELECT id,title FROM country")->queryAll();
        $countries=ArrayHelper::map($countries_query,'id','title');
        $cities_query = $dao->createCommand("SELECT id,title FROM city")->queryAll();
        $cities=ArrayHelper::map($cities_query,'id','title');

        $loc=[];

        $map=file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng={$latlong}");
        $jmap=json_decode($map,true);
        if(!empty($jmap['status']) && $jmap['status']=='OK'){
            if(!empty($jmap['results'])){
                foreach($jmap['results'] as $result){
                    if(!empty($result['address_components'])){
                        foreach($result['address_components'] as $component){
                            if($component['long_name']){$name=$component['long_name'];}
                            if(!empty($component['types'])){
                                foreach($component['types'] as $type){
                                    if($type=='sublocality' && !empty($name)){$loc['sublocality']=$name;}
                                    if($type=='locality' && !empty($name)){$loc['city']=$name;}
                                    if($type=='country' && !empty($name)){$loc['country']=$name;}
                                }
                            }
                        }
                    }
                }
            }
        }
        if(!empty($loc['country']) && !empty($loc['city'])){
            if($city_id=array_search($loc['city'],$cities)){$this->city_id=$city_id;}
            if($country_id=array_search($loc['country'],$countries)){$this->country_id=$country_id;}
            if(!empty($loc['sublocality'])){$this->neighborhood=$loc['sublocality'];}
        }

        if($address && empty($country_id) && empty($city_id)){
            $array=explode(',',$address);
            $loc['country']=trim(end($array));
            $loc['city']=trim(prev($array));
            $loc['sublocality']=trim(prev($array));

            if($city_id=array_search($loc['city'],$cities)){$this->city_id=$city_id;}
            if($country_id=array_search($loc['country'],$countries)){$this->country_id=$country_id;}
            if(!empty($loc['sublocality'])){$this->neighborhood=$loc['sublocality'];}
        }
    }

}
