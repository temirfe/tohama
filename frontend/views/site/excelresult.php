<?php

/* @var $this yii\web\View */
/* @var $time integer */
/* @var $data array|string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$name="Excel Upload Result";
$this->title = $name.' - Tohama Travel & Tourism LLC';


?>
<div class="site-data">

    <h1><?= Html::encode($name) ?></h1>

    <?php
    foreach($data as $sheet_title=>$sheet_array){
        if($sheet_array['found']){
            echo $sheet_title."<br />";
            /*foreach($sheet_array['rows'] as $sheet_rows){
                echo "<pre>";
                print_r($sheet_rows);
                echo "</pre>";
            }*/
            echo "<br />";
        }
    }
    /*if(is_array($data)){
        $i=0;
        foreach($data as $k=>$value){
            foreach($value as $k2=>$val){
                echo $i.') key1:'.$k.' key2:'.$k2;
                if(is_array($val)){
                    echo ' count:'.count($val)."<br />";
                }
                else echo ' val:'.$val."<br />";
            }
            $i++;
            echo "<br />--<br />";
        }
    }
    else echo $data;*/

    $execution_minutes=$time/60;

    echo '<br /><b>Total Execution Time:</b> '.$execution_minutes.' Mins or '.$time.' seconds';
    ?>

</div>
