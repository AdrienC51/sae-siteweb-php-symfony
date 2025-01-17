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

    public function adminLinksHere(ControllerTester $I)
    {
        $account = AccountFactory::createOne(['firstname' => 'Apollo', 'lastname' => 'Justice', 'email' => 'just@example.com', 'roles' => ['ROLE_ADMIN']]);
        $realUser = $account->_real();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/user/1');
        $I->see('Admin Links', 'h2');
    }

    public function noAccessToOtherId(ControllerTester $I)
    {
        $account = AccountFactory::createOne();
        AccountFactory::createOne();
        $realUser = $account->_real();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/user/2');
        $I->see('You should not be able to see these informations !', 'div');
    }

    public function noAccessWhenDisconnected(ControllerTester $I)
    {
        AccountFactory::createOne();
        $I->amOnPage('/user/1');
        $I->see('You are not even connected !', 'div');
    }
}
