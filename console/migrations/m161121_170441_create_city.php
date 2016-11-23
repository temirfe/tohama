<?php

use yii\db\Migration;

class m161121_170441_create_city extends Migration
{
    public function up()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'title' => $this->string('20')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('city');
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
