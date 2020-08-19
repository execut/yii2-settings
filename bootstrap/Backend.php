<?php
/**
 */

namespace execut\settings\bootstrap;


use execut\actions\Bootstrap;
use execut\navigation\Component;
use execut\crud\navigation\Configurator;
use execut\settings\models\Setting;
use execut\settings\Module;
use yii\console\Application;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

class Backend extends Common
{
    protected $isBootstrapI18n = true;
    public function getDefaultDepends(){
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'settings' => [
                    'class' => Module::class,
                ],
            ],
            'bootstrap' => [
                'actions' => [
                    'class' => Bootstrap::class,
                ],
                'crud' => [
                    'class' => \execut\crud\Bootstrap::class,
                ],
                'navigation' => [
                    'class' => \execut\navigation\Bootstrap::class,
                ],
            ],
        ]);
    }
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        parent::bootstrap($app);

        $app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $this->bootstrapNavigation($app);
        });
    }

    /**
     * @param $app
     */
    protected function bootstrapNavigation($app)
    {

        $module = $app->getModule('settings');
        if (!(!$app->user->isGuest && $module->adminRole === '@') && !$app->user->can($module->adminRole)) {
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
            'modelName' => Setting::MODEL_NAME,
            'controller' => 'backend',
        ]);
    }
}