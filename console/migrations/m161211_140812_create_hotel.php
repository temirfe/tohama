<?php

use yii\db\Migration;

class m161211_140812_create_hotel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hotel}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(500)->notNull(),
            'text' => $this->text()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'neighborhood' => $this->string(100)->notNull(),
            'address' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'latlong' => $this->string(20)->notNull(),
            'sku' => $this->string(1000)->notNull(),
            'stars' => $this->smallInteger()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_hotel_country', 'hotel', 'country_id');
        $this->createIndex('idx_hotel_city', 'hotel', 'city_id');
        $this->createIndex('idx_hotel_sku', 'hotel', 'sku');
    }

    public function down()
    {
        echo "m161211_140812_create_hotel cannot be reverted.\n";

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
