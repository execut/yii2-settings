<?php
namespace execut\settings\migrations;

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m211018_143445_addTimeType extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('settings_settings')
            ->addColumn('value_time', $this->time())
        ;
    }
}
