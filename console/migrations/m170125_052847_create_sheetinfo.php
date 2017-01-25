<?php

use yii\db\Migration;

class m170125_052847_create_sheetinfo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sheetinfo}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(1000)->notNull(),
            'description' => $this->text()->notNull(),
            'excel_id' => $this->integer()->notNull(),
            'worksheet_id' => $this->integer()->notNull(),
            'hotel_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_sinfo_excel', 'sheetinfo', 'excel_id');
        $this->createIndex('idx_sinfo_wsh', 'sheetinfo', 'worksheet_id');
        $this->createIndex('idx_sinfo_hotel', 'sheetinfo', 'hotel_id');
    }

    public function down()
    {
        echo "m170125_052847_create_sheetinfo cannot be reverted.\n";

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
