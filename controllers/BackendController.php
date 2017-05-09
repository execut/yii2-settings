<?php
/**
 */

namespace execut\settings\controllers;


use execut\crud\params\Crud;
use execut\settings\models\Setting;
use yii\web\Controller;

class BackendController extends Controller
{
    public function actions()
    {
        $configurator = new Crud([
            'modelClass' => Setting::class,
            'title' => 'Settings',
        ]);

        return $configurator->actions();
    }
}