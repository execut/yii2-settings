<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 8/28/18
 * Time: 2:02 PM
 */

namespace execut\settings\plugins;


use execut\rbac\models\Item;
use execut\settings\models\VsItem;
use execut\settings\Plugin;

class Rbac implements Plugin
{
    public function getSettingsCrudFieldsPlugins() {
        return [
            'items' => [
                'class' => \execut\rbac\crudFields\Plugin::class,
                'vsItemsClass' => VsItem::class,
                'linkAttribute' => 'settings_setting_id',
                'isLimitByActiveUserItems' => true,
            ],
        ];
    }

    public function checkHasAccessToSetting($id) {
        if (\yii::$app->user->can(\yii::$app->getModule('rbac2')->superadminRole)) {
            return true;
        }

        if (empty($id)) {
            return false;
        }

        return VsItem::find()
            ->andWhere([
                'rbac_item_id' => Item::find()->isAllowedForUserId(\yii::$app->user->identity->id)->select('id'),
                'settings_setting_id' => $id,
            ])->count() > 0;
    }
}