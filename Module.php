<?php
/**
 */

namespace execut\settings;


use execut\actions\HelpModule;
use execut\dependencies\PluginBehavior;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module implements Plugin, HelpModule
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

    public function checkHasAccessToSetting(int $id):bool {
        if (!count($this->plugins)) {
            return true;
        }

        $result = $this->getPluginsResults(__FUNCTION__, true, func_get_args());

        return (bool) $result;
    }

    public function getHelpUrl() {
        return 'https://github.com/execut/yii2-settings/wiki';
    }
}