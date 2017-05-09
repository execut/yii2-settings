<?php
/**
 */

namespace execut\settings\bootstrap;


use execut\navigation\Component;
use execut\crud\navigation\Configurator;
use execut\yii\Bootstrap;

class Backend extends Bootstrap
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        /**
         * @var Component $navigation
         */
        $navigation = $app->navigation;
        $navigation->addConfigurator([
            'class' => Configurator::class,
            'module' => 'settings',
            'moduleName' => 'Settings',
            'modelName' => 'Settings',
            'controller' => 'backend',
        ]);
    }
}