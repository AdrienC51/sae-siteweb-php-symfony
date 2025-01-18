<?php


namespace App\Tests\Controller\Restocking;

use App\Factory\AccountFactory;
use App\Factory\RestockingFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class ResShowCest
{
    public function ShowRestockingInfo(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        RestockingFactory::createOne(['status'=>'pending']);
        $I->amOnPage('/restocking/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Restocking n°1');
        $I->see('Restocking n°1','h1');
    }
    public function accessIsRestrictedToAdminUser(ControllerTester $I)
    {
        $account = AccountFactory::createOne()->_real();
        $I->amLoggedInAs($account);
        RestockingFactory::createOne(['status'=>'pending']);
        $I->amOnPage('/restocking/1');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
