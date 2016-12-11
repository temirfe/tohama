<?php

use yii\db\Migration;

class m161121_170441_create_city extends Migration
{
    public function up()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'country_id' => $this->smallInteger()->notNull(),
            'title' => $this->string('20')->notNull(),
            'text' => $this->text(),
            'image' =>$this->string('200')->notNull(),
        ]);

        $this->createIndex('idx_city_country', 'city', 'country_id');
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
