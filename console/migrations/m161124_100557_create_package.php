<?php

use yii\db\Migration;

class m161124_100557_create_package extends Migration
{
    public function up()
    {
        $this->createTable('package', [
            'id' => $this->primaryKey(),
            'title' => $this->string('500')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('package');
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
