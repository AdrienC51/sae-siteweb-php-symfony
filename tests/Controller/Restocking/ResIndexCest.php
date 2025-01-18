<?php


namespace App\Tests\Controller\Restocking;

use App\Factory\AccountFactory;
use App\Factory\RestockingFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class ResIndexCest
{
    public function showRestockingList(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        RestockingFactory::createMany(5,function (){
            $status = rand(0, 1) === 0 ? "Pending" : "Received";
            return [
                'status' => $status,
            ];
        });
        $I->amOnPage('/restocking');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.orderinfo', 5);
    }

    public function accessIsRestrictedToAuthenticatedUser(ControllerTester $I)
    {
        $I->amOnPage('/restocking');
        $I->seeCurrentRouteIs('app_login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I)
    {
        $user = AccountFactory::createOne(['roles' => ['ROLE_USER']])->_real();
        $I->amLoggedInAs($user);
        $I->amOnPage('/restocking');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function clickOnRestocking(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        RestockingFactory::createMany(5,function (){
            $status = rand(0, 1) === 0 ? "Pending" : "Received";
            return [
                'status' => $status,
            ];
        });        $I->amOnPage('/restocking');
        $I->click('Restocking n°1');
        $I->seeCurrentRouteIs('app_restocking_show', ['id' => 1]);


    }

}
