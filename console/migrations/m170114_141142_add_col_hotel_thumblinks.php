<?php

use yii\db\Migration;

class m170114_141142_add_col_hotel_thumblinks extends Migration
{
    public function up()
    {

        $this->addColumn('hotel','thumblinks','text NOT NULL');
    }

    public function down()
    {
        echo "m170114_141142_add_col_hotel_thumblinks cannot be reverted.\n";

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
