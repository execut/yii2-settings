<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 11:43 AM
 */

namespace execut\settings\bootstrap;


use yii\helpers\ArrayHelper;

class Console extends Common
{
    public function getDefaultDepends()
    {
        return ArrayHelper::merge(parent::getDefaultDepends(), [
            'modules' => [
                'settings' => [
                    'controllerNamespace' => 'execut\settings\commands',
                ],
            ],
            'bootstrap' => [
                'actions' => [
                    'class' => \execut\actions\bootstrap\Console::class,
                ],
            ]
        ]);
    }
}