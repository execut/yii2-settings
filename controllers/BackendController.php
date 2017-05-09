<?php
/**
 */

namespace execut\settings\controllers;


use execut\crud\params\Crud;
use execut\settings\models\Setting;
use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $configurator = new Crud([
            'modelClass' => Setting::class,
            'title' => 'Settings',
        ]);

        return $configurator->actions();
    }
}