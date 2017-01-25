<?php

use yii\db\Migration;

class m170125_085945_add_book_excelid extends Migration
{
    public function up()
    {
        $this->addColumn('book','excel_id','integer(11) NOT NULL');
        $this->createIndex('idx_book_excelid', 'book', 'excel_id');

    }

    public function down()
    {
        echo "m170125_085945_add_book_excelid cannot be reverted.\n";

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
