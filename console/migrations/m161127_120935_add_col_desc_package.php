<?php

use yii\db\Migration;

class m161127_120935_add_col_desc_package extends Migration
{
    public $tableName='package';
    public function up()
    {
        $this->addColumn($this->tableName,'description','varchar(255) NOT NULL');
    }

    public function down()
    {
        echo "m161127_120935_add_col_desc_package cannot be reverted.\n";

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