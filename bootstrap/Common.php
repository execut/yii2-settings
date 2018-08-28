<?php
/**
 */

namespace execut\settings\bootstrap;

use execut\settings\Component;
use execut\yii\Bootstrap;
use execut\settings\Module;
class Common extends Bootstrap
{
    public $_defaultDepends = [
        'components' => [
            'settings' => [
                'class' => Component::class,
            ]
        ],
        'modules' => [
            'settings' => [
                'class' => Module::class,
            ],
        ],
    ];
}