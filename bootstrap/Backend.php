<?php
/**
 */

namespace execut\settings\bootstrap;


use execut\navigation\Component;
use execut\crud\navigation\Configurator;
use execut\settings\models\Setting;
use execut\settings\Module;
use execut\yii\Bootstrap;
use yii\console\Application;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

class Backend extends Common
{
    public function getDefaultDepends(){
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'settings' => [
                    'class' => Module::class,
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
        $this->bootstrapNavigation($app);
        $this->bootstrapI18n($app);
    }

    /**
     * @param $app
     */
    protected function bootstrapNavigation($app): void
    {
        if ($app instanceof Application || $app->user->isGuest || !$app->user->can('settings_admin')) {
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

    public function bootstrapI18n($app) {
        $app->i18n->translations['execut/settings'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@vendor/execut/yii2-settings/messages',
            'fileMap' => [
                'execut/settings' => 'settings.php',
            ],
        ];
    }
}