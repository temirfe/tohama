<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;
use frontend\models\Hotel;
use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','upload-excel'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['upload-excel'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionPinfo(){
        echo phpinfo();
    }

    public function actionEditorUpload(){
        $file=UploadedFile::getInstanceByName('upload');
        $imageName=time().'.'.$file->extension;
        $dir=Yii::getAlias('@webroot')."/images/editor/";
        $file->saveAs($dir.'/' . $imageName);
    }
    public function actionEditorBrowse(){
        return $dir=Yii::getAlias('@webroot')."/images/editor/";
    }
    /**
     * Displays homepage.
     *
     * @return mixedh
     */
    public function actionIndex()
    {
        $dao=Yii::$app->db;
        //$cities=$dao->createCommand("SELECT id,title, image FROM city")->queryAll();
        $packages=$dao->createCommand("SELECT * FROM package ORDER BY id DESC")->queryAll();
        return $this->render('index',['packages'=>$packages]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionExplore()
    {
        $dao=Yii::$app->db;
        $cities=$dao->createCommand("SELECT id,title, image FROM city")->cache(86000)->queryAll();
        return $this->render('explore',['cities'=>$cities]);
    }

    public function actionDestinations()
    {
        //$dao=Yii::$app->db;
        //$cities=$dao->createCommand("SELECT id,title, image FROM city")->cache(86000)->queryAll();
        return $this->render('destinations',['cities'=>'']);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionImgDelete($id,$model_name)
    {
        $key=Yii::$app->request->post('key');
        $webroot=Yii::getAlias('@webroot');
        if(is_dir($dir=$webroot."/images/{$model_name}/".$id))
        {
            if(is_file($dir.'/'.$key)){
                $expl=explode('_',$key);
                $full=$expl[1];
                @unlink($dir.'/'.$key);
                @unlink($dir.'/'.$full);
                Yii::$app->db->createCommand("UPDATE {$model_name} SET image='' WHERE id='{$id}'")->execute();
            }
        }
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return true;
    }

    public function actionUploadExcel(){
        $time_start = microtime(true);
        $error=false;
        $req=Yii::$app->request;
        if(!empty($_FILES['excel']['name']))
        {
            $data=[];
            if(!$data['country_id']=$req->post('country')){$error='Please select country!';}
            if(!$data['city_id']=$req->post('city')){$error='Please select city!';}
            $data['stars']=$req->post('stars');
            if(!$error){
                $info = pathinfo($_FILES['excel']['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = time().".".$ext;

                $target = 'upload/'.$newname;
                $excel_name=$_FILES['excel']['name'];

                $dao=Yii::$app->db;
                $check_excel=$dao->createCommand("SELECT id FROM excel WHERE title=:title")->bindParam('title',$excel_name)->queryOne();
                if($check_excel){$data['excel_id']= $check_excel['id'];}
                if(!empty($data['excel_id'])){
                    $data['new_excel']=false;
                }
                else{
                    $data['new_excel']=true;
                    $dao->createCommand()->insert('excel', ['title' => $excel_name])->execute();
                    $data['excel_id']=$dao->getLastInsertID();
                }

                move_uploaded_file( $_FILES['excel']['tmp_name'], $target);
                //$parsed_data=$this->parseExcel($newname,$data);
                $parsed_data=$this->parseExcelTest($newname);
                echo "<pre>";
                print_r($parsed_data);
                echo "</pre>";
                $time_end = microtime(true);
                $execution_seconds=$time_end - $time_start;
                die();
                return $this->render('excelresult',['data'=>$parsed_data,'time'=>$execution_seconds]);
            }
        }
        else if($req->isPost){$error='No file was selected!';}

        return $this->render('loadexcel',['error'=>$error]);
    }

    protected function parseExcel($filename,$data){
        $dir=Yii::getAlias('@webroot');
        $file=$dir.'/upload/'.$filename;
        $workbook = SpreadsheetParser::open($file);
        $dao=Yii::$app->db;
        if($stars=$data['stars']){
            $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='{$data['country_id']}' AND city_id='{$data['city_id']}' AND stars='{$stars}'";
        }
        else{
            $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='{$data['country_id']}' AND city_id='{$data['city_id']}'";
        }
        $skus_rows = $dao->createCommand($skus_query)->queryAll();
        $skus=ArrayHelper::map($skus_rows,'id','title');
        $hotel_ids=ArrayHelper::map($skus_rows,'id','hotel_id');

        if(!$data['new_excel']){
            $eresult = $dao->createCommand("SELECT id,title FROM worksheet WHERE excel_id='{$data['excel_id']}'")->queryAll();
            if($eresult){
                $already_saveds=ArrayHelper::map($eresult,'id','title');
            }
        }

        $worksheets=$workbook->getWorksheets();

        $sheets = [];
        foreach($worksheets as $sheet_title){
            if($sku_id=array_search($sheet_title, $skus)){
                $sheets[$sheet_title]['found']=true;
                if(isset($already_saveds) && in_array($sheet_title, $already_saveds)){
                    $sheets[$sheet_title]['already']=true;
                }
                else{
                    $sheets[$sheet_title]['hotel_id']=$hotel_ids[$sku_id];
                    $myWorksheetIndex = $workbook->getWorksheetIndex($sheet_title);
                    $arrows=$workbook->createRowIterator($myWorksheetIndex);
                    $sheets[$sheet_title]['rows']=$this->getRows($arrows);
                }
            }
            else {
                $sheets[$sheet_title]['found']=false;
            }
        }
        $this->saveResult($sheets,$data);
        return $sheets;
    }

    protected function parseExcelTest($filename){
        $dir=Yii::getAlias('@webroot');
        $file=$dir.'/upload/'.$filename;
        $workbook = SpreadsheetParser::open($file);
        $dao=Yii::$app->db;

        $worksheets=$workbook->getWorksheets();

        $sheets = [];
        $myWorksheetIndex = $workbook->getWorksheetIndex("Grand Hyatt");
        $arrows=$workbook->createRowIterator($myWorksheetIndex);
        $sheets['rows']=$this->getRowsTest($arrows);

        return $sheets;
    }

    protected function getRowsTest($arrows){
        $start=false;
        $room_type='';
        $quality_rows=[];
        $prev_empty=false;
        $info=[];
        foreach ($arrows as $rowIndex => $arrow) {
            if(!$start){if(trim(strtolower($arrow[0]))=='room type'){$start=true;}}
            if($start && !empty($arrow[2]) && !empty($arrow[3]) && !empty($arrow[4]) && !empty($arrow[5])){
                if($arrow[0]){$room_type=$arrow[0];}

                if(is_object($arrow[3])){$fromDateObj=$arrow[3]; $date_from=$fromDateObj->format('Y-m-d');}
                else $date_from=$arrow[3]; //
                if(is_object($arrow[4])){$toDateObj=$arrow[4]; $date_to=$toDateObj->format('Y-m-d');}
                else $date_to=$arrow[4];//it's column label: "To";

                if(isset($arrow[6]))$row6=$arrow[6]; else $row6='';
                if(isset($arrow[7]))$row7=$arrow[7]; else $row7='';
                if(isset($arrow[8]))$row8=$arrow[8]; else $row8='';
                if(isset($arrow[9]))$row9=$arrow[9]; else $row9='';
                if(isset($arrow[10]))$row10=$arrow[10]; else $row10='';
                if(isset($arrow[11]))$row11=$arrow[11]; else $row11='';

                $quality_rows[]=[$room_type,$arrow[1],$arrow[2],$date_from,$date_to,$arrow[5],$row6,$row7,$row8,$row9,$row10,$row11];
                $prev_empty=false;
            }
            else{
                echo "row::".$arrow[0].' ';
                if(!$arrow[0]){
                    $prev_empty=true;
                    echo $rowIndex.') empty row <br />';
                }
                elseif(!empty($arrow[0])){
                    if($prev_empty){$info[]['title']=$arrow[0];}
                    else{$info[]['description']=$arrow[0];}
                    $prev_empty=false;
                    echo $rowIndex.') not empty <br />';
                }
            }
        }
        //return $quality_rows;
        //return $info;
    }

    protected function getRows($arrows){
        $start=false;
        $room_type='';
        $quality_rows=[];
        foreach ($arrows as $rowIndex => $arrow) {
            if(!$start){if(trim(strtolower($arrow[0]))=='room type'){$start=true;}}
            if($start && !empty($arrow[1]) && !empty($arrow[2]) && !empty($arrow[3]) && !empty($arrow[4]) && !empty($arrow[5])){
                if($arrow[0]){$room_type=$arrow[0];}

                if(is_object($arrow[3])){$fromDateObj=$arrow[3]; $date_from=$fromDateObj->format('Y-m-d');}
                else $date_from=$arrow[3]; //
                if(is_object($arrow[4])){$toDateObj=$arrow[4]; $date_to=$toDateObj->format('Y-m-d');}
                else $date_to=$arrow[4];//it's column label: "To";

                if(isset($arrow[6]))$row6=$arrow[6]; else $row6='';
                if(isset($arrow[7]))$row7=$arrow[7]; else $row7='';
                if(isset($arrow[8]))$row8=$arrow[8]; else $row8='';
                if(isset($arrow[9]))$row9=$arrow[9]; else $row9='';
                if(isset($arrow[10]))$row10=$arrow[10]; else $row10='';
                if(isset($arrow[11]))$row11=$arrow[11]; else $row11='';

                $quality_rows[]=[$room_type,$arrow[1],$arrow[2],$date_from,$date_to,$arrow[5],$row6,$row7,$row8,$row9,$row10,$row11];
            }
        }
        return $quality_rows;
    }

    protected function saveResult($result,$data){
        $batch_row=[];
        $new_saved_sheets=[];
        foreach($result as $sheet_title=>$sheet_array){
            if(!empty($sheet_array['rows'])){
                $new_saved_sheets[]=[$sheet_title,$data['excel_id']];
                foreach($sheet_array['rows'] as $sheet_row){
                    if(strtolower($sheet_row[0])!='room type'){
                        $sheet_row[12]=$sheet_array['hotel_id'];
                        $sheet_row[13]=$data['country_id'];
                        $sheet_row[14]=$data['city_id'];
                        $batch_row[]=$sheet_row;
                    }
                }
            }
        }
        $dao=Yii::$app->db;
        $dao->createCommand()->batchInsert('roomprice',
            ['room','season','meal_plan','date_from','date_to','sgl_room','dbl_person','third_pax','adult_hb','child_bb','child_eb','child_hb','hotel_id', 'country_id','city_id'],
            $batch_row
        )->execute();
        $dao->createCommand()->batchInsert('worksheet',['title','excel_id'], $new_saved_sheets)->execute();
    }

    protected function parseSingleSheet($objPHPExcel, $skus_rows){
        $sheets = [];
        //$skus=ArrayHelper::map($skus_rows,'id','title');
        //$hotel_ids=ArrayHelper::map($skus_rows,'id','hotel_id');
        $objPHPExcel->setActiveSheetIndex(2);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $sheet_title=$objWorksheet->getTitle();
        $arrows=$objWorksheet->toArray();
        $sheets[$sheet_title]['found']=true;
        $sheets[$sheet_title]['hotel_id']=4;
        $sheets[$sheet_title]['rows']=$this->getRows($arrows);
        return $sheets;
    }

    public function actionTest(){
       /* $dao=Yii::$app->db;
        $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='234' AND city_id='1' AND stars='5'";

        $skus_rows = $dao->createCommand($skus_query)->queryAll();
        $skus=ArrayHelper::map($skus_rows,'id','title');
        $skus2=ArrayHelper::map($skus_rows,'id','hotel_id');
        echo "<pre>";
        print_r($skus);
        echo "/<pre>";

        echo "<pre>";
        print_r($skus2);
        echo "/<pre>";*/

        $date_from=Yii::$app->request->get('date_from');
        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=Yii::$app->request->get('date_to');
        $date_to=date('Y-m-d',strtotime($date_to));
        $dao=Yii::$app->db;
        //$skus_query = "SELECT id,date_from, date_to,hotel_id FROM roomprice WHERE hotel_id='4' AND date_from>'{$date_from}'";
        //$skus_query = "SELECT id,date_from, date_to,hotel_id FROM roomprice WHERE hotel_id='4' AND date_to<='{$date_to}'";
        $skus_query = "SELECT id,date_from, date_to,hotel_id FROM roomprice 
                        WHERE hotel_id='4' 
                        AND room='Classic Room'
                        AND ((date_from<='{$date_from}' AND date_to>='{$date_from}') OR (date_from<='{$date_to}' AND date_to>='{$date_to}'))";
        //http://tohama.loc/site/test?date_from=27+Jan+2016?date_to=30+Jan+2016
        $skus_rows = $dao->createCommand($skus_query)->queryAll();
        echo "<pre>";
        print_r($skus_rows);
        echo "</pre>";

    }

    public function actionRun(){
        $dao=Yii::$app->db;
        $lol='Radisson Blu Hotel Deira Creek';
        $result = $dao->createCommand("SELECT * FROM sku")->queryAll();

        $skus=ArrayHelper::map($result,'id','title');
        if(in_array($lol,$skus)) echo "good"; else echo "not good";
       /* $stay_start='2016-01-27';
        $stay_end='2016-01-30';
        $stay_times=[];
        for($i=strtotime($stay_start);$i<=strtotime($stay_end);$i+=86400){
            //echo date('Y-m-d',$i)."<br />";
            $stay_times[]=$i;*/

    }


}
