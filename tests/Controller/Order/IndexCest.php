<?php

namespace App\Tests\Controller\Order;

use App\Factory\AccountFactory;
use App\Factory\ClientFactory;
use App\Factory\DeliveryFactory;
use App\Factory\OrderFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class IndexCest
{
    public function showOrderList(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        AccountFactory::createMany(1);
        ClientFactory::createMany(1);
        DeliveryFactory::createMany(1);
        OrderFactory::createMany(5);
        $I->amOnPage('/order');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.orderinfo', 5);
    }

    public function accessIsRestrictedToAuthenticatedUser(ControllerTester $I)
    {
        $I->amOnPage('/order');
        $I->seeCurrentRouteIs('app_login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I)
    {
        $user = AccountFactory::createOne(['roles' => ['ROLE_USER']])->_real();
        $I->amLoggedInAs($user);
        $I->amOnPage('/order');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function clickOnOrder(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        AccountFactory::createMany(1);
        ClientFactory::createMany(1);
        DeliveryFactory::createMany(1);
        OrderFactory::createMany(5);
        $I->amOnPage('/order');
        $I->click('Order n°1');
        $I->seeCurrentRouteIs('app_order_show', ['id' => 1]);
    }
}
