<?php
/**
 */

namespace execut\settings;


interface Plugin
{
    public function getSettingsCrudFieldsPlugins();
    public function checkHasAccessToSetting(int $id):bool;
}