<?php

use yii\db\Migration;

class m170107_174430_addcols_hotel_2 extends Migration
{
    public function up()
    {
        $this->addColumn('hotel','thumb','varchar(255) NOT NULL');
        $this->addColumn('hotel','thumbs_sprite','varchar(255) NOT NULL');
        $this->addColumn('hotel','imglinks','text NOT NULL');
    }

    public function down()
    {
        echo "m170107_174430_addcols_hotel_2 cannot be reverted.\n";

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
