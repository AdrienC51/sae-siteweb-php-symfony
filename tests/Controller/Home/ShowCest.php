<?php


namespace App\Tests\Controller\Home;

use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function tryToTest(ControllerTester $I)
    {
        $I->amOnPage('/home');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Homepage');
    }
}
