<?php

use yii\db\Migration;

class m170228_000621_addcol_roomprice extends Migration
{
    public function up()
    {
        $this->addColumn('roomprice','allocation','varchar(50) NOT NULL');
        $this->addColumn('roomprice','occupancy','varchar(50) NOT NULL');
        $this->addColumn('roomprice','adult_fb','varchar(20) NOT NULL');
        $this->addColumn('roomprice','adult_ai','varchar(20) NOT NULL');
        $this->addColumn('roomprice','child_fb','varchar(20) NOT NULL');
        $this->addColumn('roomprice','child_ai','varchar(20) NOT NULL');
    }

    public function down()
    {
        echo "m170228_000621_addcol_roomprice cannot be reverted.\n";

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
