<?php


namespace execut\settings\models;


use execut\crudFields\fields\DropDown;
use execut\crudFields\fields\Field;
use execut\crudFields\fields\HasOneSelect2;

class SettingTest extends \Codeception\Test\Unit
{
    public function testValidateRequiredFields() {
        $setting = new Setting();
        $setting->scenario = Field::SCENARIO_FORM;
        $setting->validate();
        $this->assertArrayHasKey('name', $setting->errors);
        $this->assertArrayHasKey('key', $setting->errors);
    }

    public function testDefaultType() {
        $setting = new Setting();
        $setting->scenario = Field::SCENARIO_FORM;
        $setting->validate();
        $this->assertEquals(Setting::TYPE_SIMPLE, $setting->type);
    }

    public function testSave() {
        $setting = new Setting();
        $setting->scenario = Field::SCENARIO_FORM;
        $attributes = [
            'name' => 'test name',
            'key' => 'key name',
        ];
        $setting->attributes = $attributes;
        $this->assertTrue($setting->save());
        $settingFounded = Setting::findOne(['id' => $setting->id]);
        $this->assertInstanceOf(Setting::class, $settingFounded);
        $this->assertEquals($attributes, $settingFounded->getAttributes(array_keys($attributes)));
    }

    public function testTypesList() {
        $setting = new Setting();
        $type = $setting->getField('type');
        $this->assertInstanceOf(DropDown::class, $type);
        $data = $type->data;
        $this->assertEquals(Setting::ALL_TYPES, array_keys($data));
    }
}