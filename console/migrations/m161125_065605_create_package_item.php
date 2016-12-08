<?php

use yii\db\Migration;

class m161125_065605_create_package_item extends Migration
{
    public function up()
    {
        $this->createTable('package_item', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer('6')->notNull()->defaultValue(0),
            'title' => $this->string('500')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
            'price' => $this->string('200')->notNull(),
        ]);

        $this->createIndex('idx_parent_id', 'package_item', 'parent_id');
    }

    public function down()
    {
        $this->dropTable('package_item');
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
