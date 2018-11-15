<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/15/18
 * Time: 2:17 PM
 */

namespace execut\settings\plugins;


use execut\navigation\Page;
use execut\navigation\page\NotFound;
use execut\pages\Plugin;
use yii\base\Exception;
use yii\db\ActiveQuery;

class Pages implements Plugin
{
    public $exceptions = [];
    public function getPageFieldsPlugins() {}
    public function getCacheKeyQueries() {}
    public function initCurrentNavigationPage(Page $navigationPage, \execut\pages\models\Page $pageModel) {}
    public function applyCurrentPageScopes(ActiveQuery $q) {}

    public function configureErrorPage(NotFound $notFoundPage, Exception $e)
    {
        foreach ($this->exceptions as $key => $exception) {
            $class = $exception['class'];
            if ($e instanceof $class) {
                $this->initPageByKey($notFoundPage, $key);
                return;
            }
        }
    }

    protected function initPageByKey($page, $key) {
        $settings = \yii::$app->settings;
        if ($name = $settings->get('error_' . $key . '_name')) {
            $page->name = $name;
        }

        if ($text = $settings->get('error_' . $key . '_text')) {
            $page->text = $text;
        }
    }
}