<?php

use yii\db\Migration;

class m170117_035724_create_banner extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(50)->notNull(),
            'link' => $this->string(500)->notNull(),
            'type' => $this->integer()->notNull(),
            'title' => $this->string(500)->notNull(),
            'description' => $this->string(500)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m170117_035724_create_banner cannot be reverted.\n";

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
