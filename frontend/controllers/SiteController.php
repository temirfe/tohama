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
                move_uploaded_file( $_FILES['excel']['tmp_name'], $target);
                $parsed_data=$this->parseExcel($newname,$data);
                $time_end = microtime(true);
                $execution_seconds=$time_end - $time_start;
                return $this->render('excelresult',['data'=>$parsed_data,'time'=>$execution_seconds]);
            }
        }
        else if($req->isPost){$error='No file was selected!';}

        return $this->render('loadexcel',['error'=>$error]);
    }

    protected function parseExcel($filename,$data){
        $dao=Yii::$app->db;
        if($stars=$data['stars']){
            $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='{$data['country_id']}' AND city_id='{$data['city_id']}' AND stars='{$stars}'";
        }
        else{
            $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='{$data['country_id']}' AND city_id='{$data['city_id']}'";
        }
        $skus_rows = $dao->createCommand($skus_query)->queryAll();

        $dir=Yii::getAlias('@webroot');
        if(is_file($file=$dir.'/upload/'.$filename)){
            $objReader =  \PHPExcel_IOFactory::createReaderForFile($file);
            $objReader->setReadDataOnly(true);
            $objPHPExcel=$objReader->load($file);
            //$parse_result=$this->parseSingleSheet($objPHPExcel,$skus_rows);
            $parse_result=$this->parseSheets($objPHPExcel, $skus_rows);
            $this->saveResult($parse_result,$data);
            return $parse_result;

        }
        else return 'not a valid file';
    }

    protected function saveResult($result,$data){
        $batch_row=[];
        foreach($result as $sheet_title=>$sheet_array){
            if($sheet_array['found']){
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
        Yii::$app->db->createCommand()->batchInsert('roomprice',
            ['room','season','meal_plan','date_from','date_to','sgl_room','dbl_person','third_pax','adult_hb','child_bb','child_eb','child_hb','hotel_id', 'country_id','city_id'],
            $batch_row
        )->execute();
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

    protected function parseSheets($objPHPExcel,$skus_rows){
        $sheets = [];
        $skus=ArrayHelper::map($skus_rows,'id','title');
        $hotel_ids=ArrayHelper::map($skus_rows,'id','hotel_id');
        foreach ($objPHPExcel->getAllSheets() as $sheet) {
            $sheet_title=$sheet->getTitle();
            if($sku_id=array_search($sheet_title, $skus)){
                $sheets[$sheet_title]['found']=true;
                $sheets[$sheet_title]['hotel_id']=$hotel_ids[$sku_id];
                $arrows=$sheet->toArray();
                $sheets[$sheet_title]['rows']=$this->getRows($arrows);
            }
            else {
                $sheets[$sheet_title]['found']=false;
            }
        }
        return $sheets;
    }

    protected function getRows($arrows){
        $start=false;
        $room_type='';
        $quality_rows=[];
        foreach($arrows as $arrow){
            if(!$start){if($arrow[0]=='Room Type'){$start=true;}}
            if($start && !empty($arrow[1]) && !empty($arrow[2]) && !empty($arrow[3]) && !empty($arrow[4]) && !empty($arrow[5])){
                if($arrow[0]){$room_type=$arrow[0];}

                if(strtolower($arrow[3])!='from'){$date_from=date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($arrow[3])); }
                else{$date_from=$arrow[3];}
                if(strtolower($arrow[4])!='to'){$date_to=date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($arrow[4])); }
                else{$date_to=$arrow[4];}

                $quality_rows[]=[$room_type,$arrow[1],$arrow[2],$date_from,$date_to,$arrow[5],$arrow[6],$arrow[7],$arrow[8],$arrow[9],$arrow[10],$arrow[11]];
            }
        }
        return $quality_rows;
    }

    protected function parseExcel2($filename,$data){
        $dir=Yii::getAlias('@webroot');
        if(is_file($file=$dir.'/upload/'.$filename)){
            $objReader =  \PHPExcel_IOFactory::createReaderForFile($file);
            $objReader->setReadDataOnly(true);
            $objPHPExcel=$objReader->load($file);
            //$objWorksheet = $objPHPExcel->getActiveSheet();

            $objPHPExcel->setActiveSheetIndex(2);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $arrows=$objWorksheet->toArray();

            /*echo "<pre>";
            print_r($sheetArray);
            echo "</pre>";*/

            $start=false;
            $room_type='';
            $quality_rows=[];
            foreach($arrows as $arrow){
                if(!$start){if($arrow[0]=='Room Type'){$start=true;}}
                if($start && !empty($arrow[1]) && !empty($arrow[2]) && !empty($arrow[3]) && !empty($arrow[4]) && !empty($arrow[5])){
                    if($arrow[0]){$room_type=$arrow[0];}

                    if(strtolower($arrow[3])!='from'){$date_from=date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($arrow[3])); }
                    else{$date_from=$arrow[3];}
                    if(strtolower($arrow[4])!='to'){$date_to=date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($arrow[4])); }
                    else{$date_to=$arrow[4];}

                    $quality_rows[]=[$room_type,$arrow[1],$arrow[2],$date_from,$date_to,$arrow[5],$arrow[6],$arrow[7],$arrow[8],$arrow[9],$arrow[10],$arrow[11]];
                }
            }
            echo "<pre>";
            print_r($quality_rows);
            echo "</pre>";

            $sheets = [];
            /*foreach ($objPHPExcel->getAllSheets() as $sheet) {
                echo $sheet->getTitle()."<br />";
                //$sheets[$sheet->getTitle()] = $sheet->toArray();
            }*/

            /*$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

            for ($row = 1; $row <= $highestRow; ++$row)
            {
                for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                    $curval=$objWorksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                    $curval=preg_replace('/\s+/S', " ", $curval);
                    echo $curval.'----';
                }
                echo "<br />";
            }*/
        }
        else echo 'not a valid file';
    }

    public function actionTest(){
        $dao=Yii::$app->db;
        $skus_query = "SELECT id,title,hotel_id FROM sku WHERE country_id='234' AND city_id='1' AND stars='5'";

        $skus_rows = $dao->createCommand($skus_query)->queryAll();
        $skus=ArrayHelper::map($skus_rows,'id','title');
        $skus2=ArrayHelper::map($skus_rows,'id','hotel_id');
        echo "<pre>";
        print_r($skus);
        echo "/<pre>";

        echo "<pre>";
        print_r($skus2);
        echo "/<pre>";
    }


}
