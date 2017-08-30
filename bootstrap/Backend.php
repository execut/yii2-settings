<?php
/**
 */

namespace execut\settings\bootstrap;


use execut\navigation\Component;
use execut\crud\navigation\Configurator;
use execut\yii\Bootstrap;
use yii\i18n\PhpMessageSource;

class Backend extends Bootstrap
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $this->bootstrapNavigation($app);
        $this->bootstrapI18n($app);
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

    public function bootstrapI18n($app) {
        $app->i18n->translations['execut/settings'] = [
            'class' => PhpMessageSource::class,
            'basePath' => 'vendor/execut/settings/messages',
        ];
    }
}