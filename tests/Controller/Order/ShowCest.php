<?php

namespace App\Tests\Controller\Order;

use App\Factory\AccountFactory;
use App\Factory\ClientFactory;
use App\Factory\DeliveryFactory;
use App\Factory\OrderFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function ShowOrderInfo(ControllerTester $I)
    {
        $account = AccountFactory::createOne()->_real();
        $I->amLoggedInAs($account);
        $user = AccountFactory::createOne(['firstname' => 'Monica']);
        ClientFactory::createOne(['account' => $user]);
        DeliveryFactory::createOne();
        OrderFactory::createOne();
        $I->amOnPage('/order/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Order n°1');
        $I->see('Order n°1', 'h1');
        $I->see('Monica', 'dd');
    }

    public function accessIsRestrictedToAuthenticatedUser(ControllerTester $I)
    {
        $user = AccountFactory::createOne(['firstname' => 'Monica']);
        ClientFactory::createOne(['account' => $user]);
        DeliveryFactory::createOne();
        OrderFactory::createOne();
        $I->amOnPage('/order/1');
        $I->seeCurrentRouteIs('app_login');
    }
}
