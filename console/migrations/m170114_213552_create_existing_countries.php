<?php

use yii\db\Migration;

class m170114_213552_create_existing_countries extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%existing_countries}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'code' => $this->integer(6)->notNull(),
            'country_id' => $this->integer(6)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_ex_country', 'market', 'country_id');
    }

    public function down()
    {
        echo "m170114_213552_create_existing_countries cannot be reverted.\n";

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
