<?php
/**
 */

namespace execut\settings;


use execut\dependencies\PluginBehavior;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
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

    public function getPageFieldsPlugins() {
        $result = [];
        foreach ($this->getPlugins() as $plugin) {
            $result = array_merge($result, $plugin->getPageFieldsPlugins());
        }

        return $result;
    }
}