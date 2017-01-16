<?php

use yii\db\Migration;

class m170107_060517_addcols_hotel extends Migration
{
    public function up()
    {
        $this->addColumn('hotel','location','varchar(255) NOT NULL');
        $this->addColumn('hotel','website','varchar(100) NOT NULL');
        $this->addColumn('hotel','phone','varchar(50) NOT NULL');
    }

    public function down()
    {
        echo "m170107_060517_addcols_hotel cannot be reverted.\n";

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
