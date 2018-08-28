<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 8/28/18
 * Time: 1:59 PM
 */

namespace execut\settings\models;


use yii\db\ActiveRecord;

class VsItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'settings_vs_items';
    }

    public function rules()
    {
        return [[['rbac_item_id', 'settings_setting_id'], 'safe']];
    }
}