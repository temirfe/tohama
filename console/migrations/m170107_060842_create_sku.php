<?php

use yii\db\Migration;

class m170107_060842_create_sku extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sku}}', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'title' => $this->string(50)->notNull(),
            'stars' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'location' => $this->string(30)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_sku_hotel', 'sku', 'hotel_id');
        $this->createIndex('idx_sku_country', 'sku', 'country_id');
        $this->createIndex('idx_sku_city', 'sku', 'city_id');
        $this->createIndex('idx_sku_market', 'sku', 'market_id');
        $this->createIndex('idx_sku_title', 'sku', 'title');
    }

    public function down()
    {
        echo "m170107_060842_create_sku cannot be reverted.\n";

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
