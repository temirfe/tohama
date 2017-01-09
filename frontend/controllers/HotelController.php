<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Hotel;
use frontend\models\HotelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HotelController implements the CRUD actions for Hotel model.
 */
class HotelController extends MyController
{

    /**
     * Lists all Hotel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Hotel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Hotel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Hotel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Hotel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGrab(){
        $url = Yii::$app->request->post('url');
        if($url){
            $time_start = microtime(true);
            $content=$this->getSource($url);
            \phpQuery::newDocument($content);

            //title
            $title=pq('#hp_hotel_name')->text();
            //echo $title;

            //stars
            $stars_html=pq('.hp__hotel_ratings__stars');
            $stars_text=$stars_html->find('.invisible_spoken')->text();
            $stars=preg_replace("/[^0-9]/","",$stars_text);

            //address
            $address=pq('.hp_address_subtitle')->text();
            //echo $address;

            //latlong
            $coord=pq('.map_static_zoom')->attr('style');
            preg_match('/(?:¢|cent)er=([^&]+)&/u', $coord, $coord_ar);
            if(!empty($coord_ar[1])) $latlong=$coord_ar[1]; else $latlong=false;

            //large images
            $imgdivs=pq('div.hp-gallery-slides')->children('div');
            $imgs=[];
            foreach($imgdivs as $imgdiv){
                $img=pq($imgdiv)->find('img')->attr('src');
                $img_lazy=pq($imgdiv)->find('img')->attr('data-lazy');
                if($img){$imgs[]=$img;}
                if($img_lazy){$imgs[]=$img_lazy;}
            }
            //print_r($imgs);

            //thumbnails
            $thumb_tags=pq('#photos_distinct')->children('a');
            $thumbs=[];$sprite=false;$sprite_img='';
            foreach($thumb_tags as $ttag){
                $pqtag=pq($ttag);
                $thumb=$pqtag->attr('href');
                if(!$sprite) $sprite=$pqtag->attr('style');
                if($thumb && $thumb!='#'){$thumbs[]=$thumb;}
            }
            if($sprite){preg_match('/url\(([^)]+)/u', $sprite, $sprite_ar);}
            if(!empty($sprite_ar[1])) $sprite_img=$sprite_ar[1];
            //echo $sprite_img;
            //echo $thumbs[0];

            //text
            $text=pq('#summary')->html();
            $text=preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
            $text=preg_replace("/<a.*?>.*?<\/a>/i",'', $text);
            $text=str_replace('Booking.com','Tohamatravel.com', $text);
            //echo $text;

            if($title){
                $hotel=new Hotel();
                $hotel->scenario='parse';
                $hotel->title=trim($title);
                $hotel->stars=$stars;
                $hotel->address=trim($address);
                if($latlong) $hotel->latlong=$latlong;
                if($imgs) $hotel->imglinks=implode(',',$imgs);
                if(!empty($thumbs[0])) $hotel->thumb=$thumbs[0];
                if($sprite_img) $hotel->thumbs_sprite=$sprite_img;
                $hotel->text=trim($text);
                if($hotel->save()) {return $this->redirect(['update','id'=>$hotel->id]);}
                else print_r($hotel->errors);
            }

            \phpQuery::unloadDocuments();
            $time_end = microtime(true);
            $execution_seconds=$time_end - $time_start;
            $execution_minutes = round(($execution_seconds/60),2);
            echo '<br /><b>Total Execution Time:</b> '.$execution_minutes.' Mins or '.$execution_seconds.' seconds';
            return false;
        }
        else{
            return $this->render('grab');
        }
    }

    protected function getSource($url){

        $dao=Yii::$app->db;
        $dbody = $dao->cache(function($dao) use($url) {
            return $dao->createCommand("SELECT * FROM ferrum WHERE url='{$url}'")->queryOne();
        }, 3600);

        if(!empty($dbody['id'])){
            $result=$dbody['text'];
        }
        else{
            $ch = curl_init();    // initialize curl handle
            curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:11.0) Gecko/20100101 Firefox/11.0");
            $cookie_file = "cookie1.txt";
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
            $result = curl_exec($ch); // run the whole process
            curl_close($ch);

            $dao->createCommand()->insert('ferrum', [
                'text' => $result,
                'url' => $url,
            ])->execute();
        }

        return $result;
    }
}
