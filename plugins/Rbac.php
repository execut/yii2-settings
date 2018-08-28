<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 8/28/18
 * Time: 2:02 PM
 */

namespace execut\settings\plugins;


use execut\settings\models\VsItem;
use execut\settings\Plugin;

class Rbac implements Plugin
{
    public function getSettingsCrudFieldsPlugins() {
        return [
            'items' => [
                'class' => \execut\rbac\crudFields\Plugin::class,
                'vsItemsClass' => VsItem::class,
                'linkAttribute' => 'settings_setting_id',
                'isLimitByActiveUserItems' => true,
            ],
        ];
    }
}