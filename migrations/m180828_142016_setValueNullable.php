<?php
namespace execut\settings\migrations;

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m180828_142016_setValueNullable extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_settings')
            ->alterColumnDropNotNull('value');
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
