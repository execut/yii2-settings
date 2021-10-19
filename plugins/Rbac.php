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
use yii\db\ActiveQuery;

use \execut\rbac\models\queries\Item as ItemQuery;

class Rbac implements Plugin
{
    protected ?ActiveQuery $vsItem;
    protected ?ItemQuery $itemQuery;
    public function __construct(ActiveQuery $vsItem = null, ItemQuery $itemQuery = null)
    {
        if ($vsItem === null) {
            $vsItem = VsItem::find();
        }

        $this->vsItem = $vsItem;
        if ($itemQuery === null) {
            $itemQuery = Item::find();
        }

        $this->itemQuery = $itemQuery;
    }

    public function getSettingsCrudFieldsPlugins() {
        return [
            'items' => [
                'class' => \execut\rbac\crudFields\Plugin::class,
                'vsItemsClass' => VsItem::class,
                'linkAttribute' => 'settings_setting_id',
//                'isLimitByActiveUserItems' => true,
            ],
        ];
    }

    public function checkHasAccessToSetting(int $id):bool {
        if ($id < 0) {
            return false;
        }

        if (\yii::$app->user->can(\yii::$app->getModule('rbac2')->superadminRole)) {
            return true;
        }

        if ($id === 0) {
            return false;
        }

        $identity = \yii::$app->user->identity;
        if (!$identity) {
            return false;
        }

        return $this->getVsItemQuery()
            ->andWhere([
                'rbac_item_id' => $this->getItemQuery()->isAllowedForUserId($identity->getId())->select('id'),
                'settings_setting_id' => $id,
            ])->count() > 0;
    }

    public function getVsItemQuery(): ActiveQuery
    {
        return $this->vsItem;
    }

    public function getItemQuery(): ItemQuery
    {
        return $this->itemQuery;
    }
}