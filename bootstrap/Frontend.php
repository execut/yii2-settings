<?php
/**
 */

namespace execut\settings\bootstrap;

use execut\settings\Component;
use execut\yii\Bootstrap;
class Frontend extends Bootstrap
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $app->setComponents([
            'settings' => [
                'class' => Component::class,
            ]
        ]);
    }
}