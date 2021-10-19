<?php


namespace execut\settings\models;


use execut\crudFields\fields\DropDown;
use execut\crudFields\fields\Field;
use execut\crudFields\fields\HasOneSelect2;
use execut\crudFields\fields\reloader\Reloader;
use execut\crudFields\fields\reloader\Target;
use execut\crudFields\fields\reloader\type\Dependent;
use execut\crudFields\fields\Time;

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
        $type = $setting->getField(Setting::TYPE_ATTRIBUTE);
        $this->assertInstanceOf(DropDown::class, $type);
        $data = $type->data;
        $this->assertEquals(Setting::ALL_TYPES, array_keys($data));
    }

    public function testTimeField()
    {
        $setting = new Setting();
        $time = $setting->getField(Setting::TIME_ATTRIBUTE);
        $this->assertInstanceOf(Time::class, $time);
        $this->assertFalse($time->getDisplayOnly());
    }

    public function testTimeFieldVisibilityForEditorType()
    {
        $setting = new Setting();
        $setting->load([
            Setting::TYPE_ATTRIBUTE => Setting::TYPE_EDITOR,
        ], '');
        /**
         * @var Time $time
         */
        $time = $setting->getField(Setting::TIME_ATTRIBUTE);
        $this->assertTrue($time->getDetailViewField()->getIsHidden());
    }

    public function testTimeFieldVisibilityForEmptyType()
    {
        $setting = new Setting();
        $setting->load([], '');
        /**
         * @var Time $time
         */
        $time = $setting->getField(Setting::TIME_ATTRIBUTE);
        $this->assertTrue($time->getDetailViewField()->getIsHidden());
    }

    public function testTimeFieldVisibilityForTimeType()
    {
        $setting = new Setting();
        $setting->scenario = Field::SCENARIO_FORM;
        $attributes = [
            Setting::TYPE_ATTRIBUTE => Setting::TYPE_TIME,
        ];
        $setting->load($attributes, '');
        /**
         * @var Time $time
         */
        $time = $setting->getField(Setting::TIME_ATTRIBUTE);
        $this->assertFalse($time->getDetailViewField()->getIsHidden());
    }

    public function testTimeReloader()
    {
        $setting = new Setting();
        /**
         * @var Field $type
         */
        $time = $setting->getField(Setting::TIME_ATTRIBUTE);
        $reloaders = $time->getReloaders();
        $this->assertCount(1, $reloaders);
        $reloader = $reloaders[0];
        $this->assertInstanceOf(Reloader::class, $reloader);
        $this->assertInstanceOf(Dependent::class, $reloader->getType());
        $targets = $reloader->getTargets();
        $this->assertCount(1, $targets);
        $target = $targets[0];
        $this->assertInstanceOf(Target::class, $target);
        $field = $target->getField();
        $this->assertInstanceOf(Field::class, $field);
        $this->assertEquals(Setting::TYPE_ATTRIBUTE, $field->getAttribute());
    }
}
