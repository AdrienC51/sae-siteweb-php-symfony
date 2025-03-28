<?php

namespace App\Tests\Controller\User;

use App\Factory\AccountFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function formShowsAccountDataBeforeUpdating(ControllerTester $I): void
    {
        $account = AccountFactory::createOne(['firstname' => 'Maya', 'lastname' => 'Fey', 'email' => 'fey@example.com', 'roles' => ['ROLE_USER']]);
        $realUser = $account->_real();

        $I->amLoggedInAs($realUser);
        $I->amOnPage('/user/1');
        $I->click('Modify');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_user_update', ['id' => $account->getId()]);
        $I->seeInTitle('Edition of Fey, Maya');
        $I->see('Edition of Fey, Maya', 'h1');
        $I->see('Modify', 'button');
    }

    public function noAccessToOtherId(ControllerTester $I)
    {
        $account = AccountFactory::createOne();
        AccountFactory::createOne();
        $realUser = $account->_real();

        $I->amLoggedInAs($realUser);
        $I->amOnPage('/user/2/update');
        $I->see('You should not be able to modify this account !', 'div');
    }

    public function noAccessWhenDisconnected(ControllerTester $I)
    {
        AccountFactory::createOne();

        $I->amOnPage('/user/1/update');
        $I->see('You are not even connected !', 'div');
    }
}
