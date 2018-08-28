<?php

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m180828_110745_createVsItemsTable extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_vs_items')
            ->create($this->defaultColumns())
            ->addForeignColumn('settings_settings', true)
            ->addForeignColumn('rbac_items', true);
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
