<?php

use yii\db\Migration;

class m170125_060031_add_excelid_roomprice extends Migration
{
    public function up()
    {
        $this->addColumn('roomprice','excel_id','integer(11) NOT NULL');
        $this->createIndex('idx_roomprice_excelid', 'roomprice', 'excel_id');
    }

    public function down()
    {
        echo "m170125_060031_add_excelid_roomprice cannot be reverted.\n";

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
