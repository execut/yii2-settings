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
        $this->bootstrapNavigation($app);
    }

    /**
     * @param $app
     */
    protected function bootstrapNavigation($app): void
    {
        if ($app->user->isGuest) {
            return;
        }
        /**
         * @var Component $navigation
         */
        $navigation = $app->navigation;
        $navigation->addConfigurator([
            'class' => Configurator::class,
            'module' => 'settings',
            'moduleName' => 'Settings',
            'modelName' => 'Setting',
            'controller' => 'backend',
        ]);
    }
}