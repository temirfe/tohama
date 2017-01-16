<?php

use yii\db\Migration;

class m170106_101840_create_roomprice extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%roomprice}}', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'room' => $this->string(50)->notNull(),
            'room_note' => $this->string(50)->notNull(),
            'season' => $this->string(20)->notNull(),
            'meal_plan' => $this->string(20)->notNull(),
            'date_from' => $this->date()->notNull(),
            'date_to' => $this->date()->notNull(),
            'sgl_room' => $this->integer(6)->notNull(),
            'dbl_person' => $this->string(20)->notNull(),
            'third_pax' => $this->string(20)->notNull(),
            'adult_hb' => $this->string(20)->notNull(),
            'child_bb' => $this->string(20)->notNull(),
            'child_eb' => $this->string(20)->notNull(),
            'child_hb' => $this->string(20)->notNull(),
            'promotional' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'booking_code' => $this->string(30)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_rp_hotel', 'roomprice', 'hotel_id');
        $this->createIndex('idx_rp_country', 'roomprice', 'country_id');
        $this->createIndex('idx_rp_city', 'roomprice', 'city_id');
        $this->createIndex('idx_rp_market', 'roomprice', 'market_id');
        $this->createIndex('idx_rp_from', 'roomprice', 'date_from');
        $this->createIndex('idx_rp_to', 'roomprice', 'date_to');
    }

    public function down()
    {
        echo "m170106_101840_create_roomprice cannot be reverted.\n";

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
