<?php

use yii\db\Migration;

class m170118_163620_create_worksheet extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%worksheet}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(500)->notNull(),
            'excel_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_book_hotel', 'worksheet', 'excel_id');
    }

    public function down()
    {
        echo "m170118_163620_create_worksheet cannot be reverted.\n";

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
