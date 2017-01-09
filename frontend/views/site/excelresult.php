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
    if(is_array($data)){
        $i=0;
        foreach($data as $k=>$value){
            foreach($value as $val){
                echo $i.') '.$k;
                if(is_array($val)){
                    echo ' '.count($val)."<br />";
                }
                else echo ' '.$val."<br />";
            }
            $i++;
            echo "<br />--<br />";
        }
    }
    else echo $data;

    $execution_minutes=$time/60;

    echo '<br /><b>Total Execution Time:</b> '.$execution_minutes.' Mins or '.$time.' seconds';
    ?>

</div>
