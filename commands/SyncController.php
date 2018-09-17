<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/17/18
 * Time: 11:24 AM
 */

namespace execut\settings\commands;


use execut\settings\models\RemoteSetting;
use execut\settings\models\Setting;
use yii\console\Controller;
use yii\db\Connection;

class SyncController extends Controller
{
    public function actionIndex() {
        $localSettings = Setting::find()->all();
        foreach ($localSettings as $localSetting) {
            $result = RemoteSetting::findOrCreateByKey($localSetting->key);
            if ($result->isNewRecord) {
                $result->attributes = $localSetting->attributes;
                $result->save();
            }
        }
    }
}