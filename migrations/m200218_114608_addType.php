<?php
namespace execut\settings\migrations;
use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m200218_114608_addType extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_settings')
            ->addColumn('type', $this->string())
            ->createIndex('type')
            ->update([
                'type' => 'simple'
            ])
            ->alterColumnSetNotNull('type')
        ;
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
