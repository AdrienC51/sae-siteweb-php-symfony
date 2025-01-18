<?php

namespace App\Tests\Controller\User;

use App\Tests\Support\ControllerTester;

class RegisterCest
{
    public function form(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->click('You don\'t have an account ?');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_user_register');
        $I->seeInTitle('Make your new account !');
        $I->see('Make your new account !', 'h1');
        $I->see('Create', 'button');
    }
}
