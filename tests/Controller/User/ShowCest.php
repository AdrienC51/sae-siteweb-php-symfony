<?php


namespace App\Tests\Controller\User;

use App\Factory\AccountFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function linkToTest(ControllerTester $I)
    {
        AccountFactory::createMany(5);
        $account = AccountFactory::createOne(['firstname' => 'Morgan', 'lastname' => 'Freeman', 'email' => 'free@example.com', 'roles' => ['ROLE_USER']]);
        AccountFactory::createMany(5);
        $realUser = $account->_real();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/home');
        $I->click('account_circleAccount');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_user_show', ['id' => $account->getId()]);
    }
}
