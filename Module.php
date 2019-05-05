<?php
/**
 */

namespace execut\settings;


use execut\dependencies\PluginBehavior;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module implements Plugin
{
    public $adminRole = '@';
    public function behaviors()
    {
        return [
            [
                'class' => PluginBehavior::class,
                'pluginInterface' => Plugin::class,
            ],
        ];
    }

    public function getSettingsCrudFieldsPlugins() {
        $fields = $this->getPluginsResults(__FUNCTION__);
        if (empty($fields)) {
            $fields = [];
        }

        return $fields;
    }

    public function checkHasAccessToSetting($id) {
        if (!count($this->plugins)) {
            return true;
        }

        $result = $this->getPluginsResults(__FUNCTION__, true, func_get_args());

        return $result;
    }
}