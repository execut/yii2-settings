<?php

namespace execut\settings\models;

use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\Id;
use execut\crudFields\fields\Textarea;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "settings_settings".
 */
class RemoteSetting extends Setting
{
    public static function getDb()
    {
        return \yii::$app->remoteDbForSettingsSync;
    }
}
