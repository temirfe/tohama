<?php

use yii\db\Migration;

class m161120_065441_create_page extends Migration
{
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'url' => $this->string('20')->notNull(),
            'title' => $this->string('250')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
            'category' => $this->integer('6')->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx_page_url', 'page', 'url');
        $this->createIndex('idx_page_category', 'page', 'category');
    }

    public function down()
    {
        $this->dropTable('page');
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
