<?php

use yii\db\Migration;

class m170106_052103_addcol_city_country_id extends Migration
{
    public function up()
    {
        $this->addColumn('city','country_id','integer(11) NOT NULL');
    }

    public function down()
    {
        echo "m170106_052103_addcol_city_country_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
