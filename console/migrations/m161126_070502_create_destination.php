<?php

use yii\db\Migration;

class m161126_070502_create_destination extends Migration
{
    public function up()
    {
        $this->createTable('destination', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer('6')->notNull()->defaultValue(0),
            'title' => $this->string('20')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
            'price' => $this->string('200')->notNull(),
            'place'=> $this->string('200')->notNull(),
        ]);

        //$this->createIndex('idx_parent_id', 'package_item', 'parent_id');
    }

    public function down()
    {
        $this->dropTable('destination');
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
