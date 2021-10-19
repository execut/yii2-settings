<?php

namespace execut\settings\tests\unit\plugins;

use Codeception\Test\Unit;
use execut\rbac\Module;
use execut\settings\plugins\Rbac;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;
use yii\web\User;
use \execut\rbac\models\queries\Item as ItemQuery;

class RbacTest extends Unit
{
    protected function setUp():void
    {
        $rbacModule = new Module('rbac2');
        \yii::$app->setModule('rbac2', $rbacModule);

        parent::setUp();
    }

    public function testCheckHasAccessToSettingForAdmin(): void
    {
        $rbacModule = new Module('rbac2');
        \yii::$app->setModule('rbac2', $rbacModule);

        $user = $this->getMockBuilder(User::class)->getMock();
        $user->method('can')
            ->with('admin')
            ->willReturn(true);

        \yii::$app->set('user', $user);

        $plugin = new Rbac();
        $this->assertTrue($plugin->checkHasAccessToSetting(123));
    }

    public function testCheckHasAccessToSettingWithZeroIdForSimpleUser(): void
    {
        $rbacModule = new Module('rbac2');
        \yii::$app->setModule('rbac2', $rbacModule);

        $user = $this->getMockBuilder(User::class)->getMock();
        $user->method('can')
            ->with('admin')
            ->willReturn(false);

        \yii::$app->set('user', $user);

        $plugin = new Rbac();
        $this->assertFalse($plugin->checkHasAccessToSetting(0));
    }

    public function testCheckHasAccessToSettingWithZeroIdForAdmin(): void
    {
        $rbacModule = new Module('rbac2');
        \yii::$app->setModule('rbac2', $rbacModule);

        $user = $this->getMockBuilder(User::class)->getMock();
        $user->method('can')
            ->with('admin')
            ->willReturn(true);

        \yii::$app->set('user', $user);

        $plugin = new Rbac();
        $this->assertTrue($plugin->checkHasAccessToSetting(0));
    }

    public function testCheckHasAccessToSettingWithLessZeroId(): void
    {
        $plugin = new Rbac();
        $this->assertFalse($plugin->checkHasAccessToSetting(-1));
    }

    public function testGetVsItemQuery(): void
    {
        $plugin = new Rbac();
        $this->assertInstanceOf(ActiveQuery::class, $plugin->getVsItemQuery());
    }

    public function testSetVsItemQuery(): void
    {
        $query = new ActiveQuery('t');
        $plugin = new Rbac($query);
        $this->assertEquals($query, $plugin->getVsItemQuery());
    }

    public function testGetItemQuery(): void
    {
        $plugin = new Rbac();
        $this->assertInstanceOf(ItemQuery::class, $plugin->getItemQuery());
    }

    public function testSetItemQuery(): void
    {
        $query = new ItemQuery('t');
        $plugin = new Rbac(null, $query);
        $this->assertEquals($query, $plugin->getItemQuery());
    }

    public function testCheckHasAccessViaVsItemsQuery(): void
    {
        $plugin = $this->getPluginForCount(1);
        $this->assertTrue($plugin->checkHasAccessToSetting(123));
    }

    public function testCheckHasAccessViaVsItemsQueryForZeroItemsCount(): void
    {
        $plugin = $this->getPluginForCount(0);
        $this->assertFalse($plugin->checkHasAccessToSetting(123));
    }

    public function testCheckHasAccessViaVsItemsWithoutUserIdentity(): void
    {
        $plugin = new Rbac();

        $identity = $this->getMockBuilder(IdentityInterface::class)->getMock();
        $this->initUser($identity);
        \yii::$app->user->identity = null;

        $this->assertFalse($plugin->checkHasAccessToSetting(123));
    }

    /**
     * @param int $count
     * @return Rbac
     * @throws \yii\base\InvalidConfigException
     */
    protected function getPluginForCount(int $count): Rbac
    {
        $query = $this->getMockBuilder(ActiveQuery::class)->setConstructorArgs(['test'])->getMock();
        $query->expects($this->once())
            ->method('andWhere')
            ->willReturn($query);
        $query->method('count')
            ->willReturn($count);
        $identity = $this->getMockBuilder(IdentityInterface::class)->getMock();
        $identity->method('getId')
            ->willReturn(333);

        $this->initUser($identity);

        $itemQuery = $this->getMockBuilder(ItemQuery::class)
            ->setConstructorArgs(['test'])
            ->getMock();
        $itemQuery->expects($this->once())
            ->method('isAllowedForUserId')
            ->with(333)
            ->willReturn($itemQuery);

        $plugin = new Rbac($query, $itemQuery);
        return $plugin;
    }

    protected function initUser($identity): void
    {
        $user = new User([
            'identityClass' => get_class($identity)
        ]);

        $user->setIdentity($identity);
        \yii::$app->set('user', $user);
    }
}