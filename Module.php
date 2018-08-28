<?php
/**
 */

namespace execut\settings;


use execut\dependencies\PluginBehavior;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module implements Plugin
{
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
        return $this->getPluginsResults(__FUNCTION__);
    }
}