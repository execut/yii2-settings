<?php
namespace execut\settings\migrations;

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m180827_141237_changeValueFieldType extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_settings')
            ->delete()
            ->changeColumnType('value', $this->string()->notNull(), $this->text()->notNull());
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
