<?php

use yii\db\Migration;

class m170107_062237_create_market extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%market}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'code' => $this->integer(6)->notNull(),
            'country_id' => $this->integer(6)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_market_country', 'market', 'country_id');
        $this->createIndex('idx_market_title', 'market', 'code');
    }

    public function down()
    {
        echo "m170107_062237_create_market cannot be reverted.\n";

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
