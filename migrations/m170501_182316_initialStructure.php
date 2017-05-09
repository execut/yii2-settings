<?php

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m170501_182316_initialStructure extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_settings')
            ->create([
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'key' => $this->string()->notNull(),
                'value' => $this->string()->notNull(),
            ])
            ->createIndex('key', true);
    }
}
