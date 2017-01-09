<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class MyModel extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $imageFiles=array();

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        $this->saveImage();
        $this->optimizeImage();
    }

    /*public function afterFind()
    {
        parent::afterFind();
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'extensions' => 'jpg,jpeg,gif,png'],
            [['imageFiles'], 'file', 'extensions' => 'jpg,jpeg,gif,png', 'maxSize'=>20*1024*1024, 'maxFiles'=>10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => Yii::t('app', 'Main Image'),
            'imageFiles' => Yii::t('app', 'Other Images'),
        ];
    }

    protected function saveImage(){
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFiles = UploadedFile::getInstances($this, 'imageFiles');

        if (Yii::$app->request->serverName=='tohama.loc') {
            Image::$driver = [Image::DRIVER_GD2];
        }

        $model_name=Yii::$app->controller->id;
        $dir=Yii::getAlias('@webroot')."/images/{$model_name}/";
        if (!file_exists($dir)) {mkdir($dir);}

        $tosave=$dir.$this->id;
        if (!file_exists($tosave)) {
            mkdir($tosave);
        }

        if($this->imageFile){
            $time=time();
            $extension=$this->imageFile->extension;
            $imageName=$time.'.'.$extension;
            $this->imageFile->saveAs($tosave.'/' . $imageName);

            $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
            $imagine->thumbnail(new Box(1500, 1000))->save($tosave.'/'.$imageName);
            //$imagine->thumbnail(new Box(400, 250))->save($tosave.'/s_'.$imageName);
            Image::thumbnail($tosave.'/'.$imageName,375, 200)->save($tosave.'/s_'.$imageName);

            Yii::$app->db->createCommand("UPDATE {$model_name} SET image='{$imageName}' WHERE id='{$this->id}'")->execute();
        }
        if($this->imageFiles){
            foreach($this->imageFiles as $image)
            {
                $time=time().rand(1000, 100000);
                $extension=$image->extension;
                $imageName=$time.'.'.$extension;

                $image->saveAs($tosave.'/' . $imageName);
                $imagine=Image::getImagine()->open($tosave.'/'.$imageName);
                $imagine->thumbnail(new Box(1500, 1000))->save($tosave.'/' .$imageName);
                $imagine->thumbnail(new Box(400, 250))->save($tosave.'/s_'.$imageName);
                //Image::thumbnail($tosave.'/'.$imageName,250, 250)->save($tosave.'/s_'.$imageName);
            }
        }
    }

    protected function optimizeImage(){
        $webroot=Yii::getAlias('@webroot');
        $model_name=Yii::$app->controller->id;
        $folder=$webroot."/images/{$model_name}/".$this->id;
        if(is_dir($folder)){
            $scaned=scandir($folder);
            foreach($scaned as $scan){
                if($scan!='.'&& $scan!='..'){
                    $exp=explode('.',$scan);
                    if(isset($exp[1])){
                        $ext=strtolower($exp[1]);
                        $file=$folder.'/'.$scan;
                        if($ext=='jpg' || $ext=='jpeg'){
                            $command ='jpegoptim '.$file.' --strip-all --all-progressive';
                            shell_exec($command);
                        }
                        elseif($ext=='png'){
                            $command ='optipng '.$file;
                            shell_exec($command);
                        }
                    }
                }
            }
        }
    }

    public function afterDelete(){
        parent::afterDelete();
        $webroot=Yii::getAlias('@webroot');
        $model_name=Yii::$app->controller->id;
        if(is_dir($dir=$webroot."/images/{$model_name}/".$this->id)){
            $scaned_images = scandir($dir, 1);
            foreach($scaned_images as $file )
            {
                if(is_file($dir.'/'.$file)) @unlink($dir.'/'.$file);
            }
            @rmdir($dir);
        }
    }
}
