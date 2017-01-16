<?php

use yii\db\Migration;

class m170116_114646_create_book extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(500)->notNull(),
            'name' => $this->string(500)->notNull(),
            'phone' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull(),
            'note' => $this->string(500)->notNull(),
            'hotel_id' => $this->integer()->notNull(),
            'admin_note' => $this->string(500)->notNull(),
            'date_book' => $this->timestamp(),
        ], $tableOptions);

        $this->createIndex('idx_book_hotel', 'book', 'hotel_id');
    }

    public function down()
    {
        echo "m170116_114646_create_book cannot be reverted.\n";

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
