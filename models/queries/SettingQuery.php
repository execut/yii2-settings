<?php

namespace execut\settings\models\queries;

/**
 * This is the ActiveQuery class for [[\execut\settings\models\Setting]].
 *
 * @see \execut\settings\models\Setting
 */
class SettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \execut\settings\models\Setting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \execut\settings\models\Setting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byKey($key) {
        return $this->andWhere([
            'key' => $key,
        ]);
    }
}
